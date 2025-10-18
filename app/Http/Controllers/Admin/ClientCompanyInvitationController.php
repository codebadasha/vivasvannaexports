<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DefaultResponse;
use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Models\ClientCompanyInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientCompanyInvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin'); // only admin access
    }

    /**
     * Show list of invitations
     */
    public function index()
    {
        try {
            $invitations = ClientCompanyInvitation::where('is_master', false)->latest()->get();

            return view('admin.company-invitation.list', compact('invitations'));
        } catch (\Exception $e) {
            Log::error('Error fetching invitations: ' . $e->getMessage());

            return back()->withErrors('Unable to fetch invitations, please try again.');
        }
    }

    public function masterLink()
    {
        try {
            $invitations = ClientCompanyInvitation::where('is_master', true)->latest()->get();
            $masterInvitation = ClientCompanyInvitation::where('is_master', true)
                ->where('created_by', Auth::guard('admin')->id())
                ->latest()
                ->first();

            $masterLink = $masterInvitation ? $masterInvitation->url : null;
            return view('admin.company-invitation.master_register', compact('invitations', 'masterLink'));
        } catch (\Exception $e) {
            Log::error('Error fetching invitations: ' . $e->getMessage());

            return back()->withErrors('Unable to fetch invitations, please try again.');
        }
    }

    public function create()
    {
        return view('admin.company-invitation.add');
    }

    public function store(Request $request)
    {
        $route = 'admin.invitations.index';

        try {
            // ✅ Step 1: Validate input
            $validated = $request->validate([
                'emails'   => 'required|array|min:1',
                'emails.*' => 'required|email',
            ]);

            $emails = array_map('strtolower', $validated['emails']); // Normalize emails
            $invitations = [];
            $failedEmails = []; // Store failed emails

            // ✅ Step 2: Fetch existing invitations (not registered)
            $existingInvitations = ClientCompanyInvitation::whereIn('email', $emails)
                ->where('is_registered', false)
                ->get()
                ->keyBy('email');

            DB::beginTransaction();

            foreach ($emails as $index => $email) {
                try {
                    if ($existingInvitations->has($email)) {
                        $invitation = $existingInvitations[$email];
                    } else {
                        $token = (string) Str::uuid();

                        $invitation = ClientCompanyInvitation::create([
                            'email'  => $email,
                            'token'  => $token,
                            'url'    => '',
                            'created_by' => Auth::guard('admin')->id(), // placeholder
                        ]);

                        $url = route('company.register', ['token' => urlencode($token)]) . $invitation->id;
                        $invitation->update(['url' => $url]);
                    }

                    $invitations[] = $invitation;

                    // ✅ Prepare mail data
                    $subject = 'Invitation to Join the Vivasvanna Exports Dashboard';
                    $viewFile = 'mail-template.client-invitation';
                    $data = [
                        'invitation_link' => $invitation->url,
                        'signature_name'  => 'Vivasvanna Support Team',
                        'signature_number' => '+91-9979955809',
                        'support_emailId' => 'info@vivasvannaexports.com',
                        'support_number'  => ['+919979955809', '+91-9979955809'],
                    ];

                    $response = MailHelper::send($email, $subject, $viewFile, $data);

                    // ✅ Send mail
                    if (!$response['status']) {
                        $failedEmails[] = [
                            'sr_no' => $index + 1,
                            'email' => $email,
                            'error' => 'Mail send failed: ' . $response['message'],
                        ];
                        Log::error("Invitation email failed for {$email}: " . $response['message']);
                    }
                } catch (\Throwable $loopEx) {
                    $failedEmails[] = [
                        'sr_no' => $index + 1,
                        'email' => $email,
                        'error' => 'Processing failed: ' . $loopEx->getMessage(),
                    ];
                    Log::error("Error processing invitation for {$email}: " . $loopEx->getMessage(), [
                        'trace' => $loopEx->getTraceAsString(),
                    ]);
                }
            }

            DB::commit();

            // ✅ Step 3: Check failures
            if (!empty($failedEmails)) {
                $filename = 'failed_invitations_' . now()->format('Ymd_His') . '.csv';
                $filepath = storage_path('app/' . $filename);

                $file = fopen($filepath, 'w');
                fputcsv($file, ['Sr No', 'Email', 'Error']);
                foreach ($failedEmails as $fail) {
                    fputcsv($file, [$fail['sr_no'], $fail['email'], $fail['error']]);
                }
                fclose($file);

                // Store CSV path in session
                $message = DefaultResponse::error('Some emails could not be sent. Check the file for details.');
                $message['type'] = 'success';
                return redirect()->route($route)->with([
                    'messages'   => [$message],
                    'failed_csv' => $filename,
                ]);
            } else {
                // All emails sent successfully
                $message = DefaultResponse::success($invitations, 'All invitations sent successfully.');
                $message['type'] = 'success';
                return redirect()->route($route)->with('messages', [$message]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $e) {
            DB::rollBack();
            // Log unexpected errors
            Log::error('Error processing invitations: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            $message = DefaultResponse::error('Failed to process invitations, please try again.');
            return redirect()->back()->with('messages', [$message])->withInput();
        }
    }

    /**
     * Resend invitation
     */
    public function resend(Request $request)
    {
        try {
            $invitation = ClientCompanyInvitation::where('token', $request->token)->first();

            $subject = 'Invitation to Join the Vivasvanna Exports Dashboard';
            $viewFile = 'mail-template.client-invitation';
            $data = [
                'invitation_link' => $invitation->url,
                'signature_name'  => 'Vivasvanna Support Team',
                'signature_number' => '+91-9979955809',
                'support_emailId' => 'info@vivasvannaexports.com',
                'support_number'  => ['+919979955809', '+91-9979955809'],
            ];

            $response = MailHelper::send($invitation->email, $subject, $viewFile, $data);
            if (!$response['status']) {
                Log::error("Resend failed for {$invitation->email}: " . $response['message']);

                return response()->json(DefaultResponse::error(
                    "Mail send failed: " . $response['message']
                ));
            }

            Log::info("Invitation resent successfully to: " . $invitation->email);

            return response()->json(DefaultResponse::success(null, 'Invitation resent successfully.'));
        } catch (\Exception $e) {
            Log::error('Error resending invitation: ' . $e->getMessage());
            return response()->json(DefaultResponse::error('Failed to resend invitation, please try again.'));
        }
    }

    public function createMasterInvitation()
    {
        try {
            $authUser = Auth::guard('admin')->user();

            if (!$authUser) {
                return response()->json(DefaultResponse::error('Unauthorized user'), 401);
            }

            $token = (string) Str::uuid();


            ClientCompanyInvitation::where('email', $authUser->email)
                ->where('is_registered', false)
                ->update([
                    'is_registered' => true,
                    'status' => 2,
                ]);


            $masterLink = ClientCompanyInvitation::Create(
                [
                    'email'      => $authUser->email,
                    'token'      => $token,
                    'url'        => '',
                    'is_master'  => true,
                    'created_by' => $authUser->id,
                ]
            );

            $url = route('company.register', ['token' => urlencode($token)]) . $masterLink->id;
            $masterLink->update(['url' => $url]);

            return response()->json(DefaultResponse::success([
                'link' => $url,
            ], 'Master invitation created/updated successfully.'));
        } catch (\Throwable $e) {
            Log::error('Failed to create/update master invitation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return response()->json(DefaultResponse::error('Failed to create/update master invitation, please try again.'), 500);
        }
    }
}
