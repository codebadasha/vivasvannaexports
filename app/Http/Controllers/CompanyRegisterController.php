<?php

namespace App\Http\Controllers;

use App\Helpers\DefaultResponse;
use App\Models\Admin;
use App\Models\ClientCompany;
use App\Models\ClientCompanyContact;
use App\Models\ClientCompanyInvitation;
use App\Models\ClientGstDetail;
use App\Models\CompanyTeamMember;
use App\Models\MasterLinkRegistration;
use App\Services\SurepassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CompanyRegisterController extends Controller
{
    public function index($token)
    {
        try {

            $uniqueToken   = substr($token, 0, 36);   // always first 36 chars
            $id = substr($token, 36);
            $isvalideUrl = ClientCompanyInvitation::where('token', $uniqueToken)->where('id', $id)->first();

            $is_registered = $isvalideUrl->is_registered;
            if (!$isvalideUrl) {
                session([
                    'access_status' => true,
                    'status_type' => 'invalid'
                ]);
                return redirect()->route('invalid-link');
            }

            if ($is_registered == true) {
                $status = $isvalideUrl->created_at->isToday()
                    ? 'registered'
                    : 'already_registered';
                session([
                    'access_status' => true,
                    'status_type' => $status
                ]);
                return redirect()->route('welcome');
            }

            return view('company-register', compact('token'));
        } catch (\Exception $e) {

            Log::error('Invalid Invitation link', [
                'error' => $e->getMessage()
            ]);
            session([
                'access_status' => true,
                'status_type' => 'invalid'
            ]);
            return redirect()->route('invalid-link');
        }
    }

    public function store(Request $request, SurepassService $surepass)
    {
        // dd($request->cin !== null ? 1 : 0);
        try {
            $request->validate([
                'token'           => 'required|string',
                'company_name'   => 'required|string|max:255',
                'director_name'  => 'required|string|max:255',
                'pan_number'     => 'required|string|max:10',
                'gstn'           => 'required|string|size:15',
                'state_id'       => 'required|string',
                'turnover'       => 'required|integer',
                'mobile_number'  => 'required|digits:10',
                'email_id'       => 'required|email|max:255',
                'password'       => 'required|string|min:8|confirmed',
                'cin'            => 'nullable|string|max:21',

                'authorized' => 'required|array|min:1',
                'authorized.*.name' => 'required|string|max:255',
                'authorized.*.email' => 'required|email|max:255',
                'authorized.*.mobile' => 'required|digits:10',

                'contact' => 'required|array|min:1',
                'contact.*.name' => 'required|string|max:255',
                'contact.*.email' => 'required|email|max:255',
                'contact.*.mobile' => 'required|digits:10',
            ], [
                'password.confirmed' => 'Password and confirm password must match.',
                'authorized.required' => 'At least one authorized person is required.',
                'contact.required' => 'At least one contact person is required.',
            ]);

            $uniqueToken   = substr($request->token, 0, 36);   // always first 36 chars
            $id = substr($request->token, 36);
            $invitation = ClientCompanyInvitation::where('token', $uniqueToken)->where('id', $id)->first();

            if (!$invitation) {
                session([
                    'access_status' => true,
                    'status_type' => 'invalid'
                ]);
                return redirect()->route('invalid-link');
            }

            $panNumber = strtoupper($request->pan_number);
            // Step 3: Get GST by PAN
            // $gstByPan = $this->surepass->getGstByPan($panNumber);
            // if (!$gstByPan['status']) {
            //     Log::error('GST by PAN retrieval failed', [
            //         'pan' => $panNumber,
            //         'error' => $gstByPan['message'] ?? 'Unknown error'
            //     ]);
            //     return response()->json(DefaultResponse::error(
            //         $gstByPan['message'] ?? 'GST by PAN retrieval failed'
            //     ), 400);
            // }
            $msmeCheck = $surepass->msmeVerification($panNumber);
            $msme_register = 0; // default = not MSME
            if ($msmeCheck['status']) {
                $msmeData = $msmeCheck['data'] ?? [];

                if (!empty($msmeData['udyam_exists']) && $msmeData['udyam_exists'] === true) {
                    $msme_register = 1;
                }
            }
            

            DB::transaction(function () use ($request, $invitation, $panNumber, $msme_register) {
                $uuid = (string) Str::uuid();

                $gstNumber = strtoupper($request->gstn);
               
                $companyData = [
                    'uuid' => $uuid,
                    'director_name' => $request->director_name,
                    'pan_number' => $panNumber,
                    'company_name' => $request->company_name,
                    'mobile_number' => $request->mobile_number,
                    'email' => $request->email_id,
                    'password' => bcrypt($request->password),
                    'address' => $request->address,
                    'state_id' => $request->state_id,
                    'gstn' => $gstNumber,
                    'cin' => $request->cin,
                    'cin_verify' => $request->cin !== null ? 1 : 0,
                    'msme_register' => $msme_register,
                    'turnover' => $request->turnover,
                    'is_verify' => 1,
                    'is_active' => 1,
                ];

                $company = ClientCompany::create($companyData);

                $companyGstDetails = ClientGstDetail::where('gstn', $request->gstn)->first();
                if ($companyGstDetails) {
                    $companyGstDetails->client_company_id = $company->id;
                    $companyGstDetails->save();
                }

                if ($invitation->is_master == true) {
                    MasterLinkRegistration::Create(
                        [
                            'invitation_id' => $invitation->id,
                            'gstn'=> $gstNumber
                        ]
                    );
                } else {
                    $invitation->is_registered = true;
                    $invitation->status = 2;
                    $invitation->gstn = $gstNumber;
                    $invitation->save();
                }
                
                if (!empty($request->authorized)) {
                    foreach ($request->authorized as $person) {
                        ClientCompanyContact::create([
                            'client_company_id' => $company->id,
                            'name'              => $person['name'],
                            'email'             => $person['email'],
                            'mobile'            => $person['mobile'],
                        ]);
                    }
                }

                if (!empty($request->contact)) {
                    foreach ($request->contact as $person) {
                        ClientCompanyContact::create([
                            'client_company_id' => $company->id,
                            'name'              => $person['name'],
                            'email'             => $person['email'],
                            'mobile'            => $person['mobile'],
                        ]);
                    }
                }
                $teamMember = Admin::select('id')->where('is_default', 1)->first() ?? Admin::select('id')->where('role_id', 4)->first();

                $team = new CompanyTeamMember;
                $team->client_company_id = $company->id;
                $team->admin_id = $teamMember->id;
                $team->save();
            });
            session([
                'access_status' => true,
                'status_type' => 'registered'
            ]);
            return redirect()->route('welcome');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for company registration', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('messages', [
                    ['type' => 'error', 'message' => 'Validation failed. Please check your inputs.']
                ]);
        } catch (\Exception $e) {
            dd('yes');
            Log::error('Client company creation failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('messages', [
                    ['type' => 'error', 'message' => 'Something went wrong. Please try again.']
                ]);
        }
    }

    public function invalidLink()
    {
        if (session('access_status') !== true) {
            abort(403);
        }
        $status = session('status_type');

        return view('registration-status', compact('status'));
    }

    public function welcome()
    {
        if (session('access_status') !== true) {
            abort(403);
        }

        $status = session('status_type');

        return view('registration-status', compact('status'));
    }

    public function gstVerification(Request $request, SurepassService $surepass)
    {
        try {
            // Validate GSTIN input
            $validated = $request->validate([
                'gstin' => [
                    'required',
                    'string',
                    'size:15',
                    'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{1}Z[A-Z0-9]{1}$/'
                ]
            ]);

            return $surepass->verificationProcess($request->gstin);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', [
                'gstin' => $request->gstin,
                'errors' => $e->errors()
            ]);
            return response()->json(DefaultResponse::error('Invalid GSTIN format'), 422);
        }
    }
}
