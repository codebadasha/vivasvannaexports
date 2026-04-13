<?php

namespace App\Http\Controllers;

use App\Helpers\DefaultResponse;
use App\Models\Admin;
use App\Models\ClientCompany;
use App\Models\ClientCompanyContact;
use App\Models\ClientCompanyInvitation;
use App\Models\ClientGstDetail;
use App\Models\ClientGstin;
use App\Models\CompanyTeamMember;
use App\Models\MasterLinkRegistration;
use App\Services\PerfiosService;
use App\Services\SurepassService;
use App\Services\ZohoBookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Helpers\MailHelper;

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

    public function store(Request $request, SurepassService $surepass, ZohoBookService $zoho, PerfiosService $perfios)
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
                'cin'            => 'nullable|string|max:21',

                                'contact' => 'required|array|min:1',

                'contact.*.name' => 'required|string|max:255',
                'contact.*.email' => 'required|email|max:255',
                'contact.*.mobile' => 'required|digits:10',
                'contact.*.phone' => 'nullable|digits:10',
                'contact.*.designation' => 'nullable|string',
            ], [
                'contact.required' => 'At least one contact person is required.',
            ], 
            [
                // ✅ Attribute rename (IMPORTANT 🔥)
                'contact.*.email' => 'Email',
                'contact.*.mobile' => 'Mobile number',
                'contact.*.name' => 'Name',
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
        
            $msmeCheck = $surepass->msmeVerification($panNumber);
            $msme_register = 0; // default = not MSME
            if ($msmeCheck['status']) {
                $msmeData = $msmeCheck['data'] ?? [];

                if (!empty($msmeData['udyam_exists']) && $msmeData['udyam_exists'] === true) {
                    $msme_register = 1;
                }
            }
            

            DB::transaction(function () use ($perfios, $zoho, $request, $invitation, $panNumber, $msme_register) {
                $uuid = (string) Str::uuid();

                $gstNumber = strtoupper($request->gstn);
               
                $companyData = [
                    'uuid' => $uuid,
                    'director_name' => $request->director_name,
                    'pan_number' => $panNumber,
                    'company_name' => $request->company_name,
                    'mobile_number' => $request->mobile_number,
                    'email' => $request->email_id,
                    'password' => bcrypt($uuid),
                    'address' => $request->address,
                    'state_id' => $request->state_id,
                    'gstn' => $gstNumber,
                    'cin' => $request->cin,
                    'cin_verify' => $request->cin !== null ? 1 : 0,
                    'msme_register' => $msme_register,
                    'turnover' => $request->turnover,
                    'is_verify' => 0,
                    'is_active' => 0,
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
                            'client_company_id' => $company->id,
                            'invitation_id' => $invitation->id,
                            'gstn'=> $gstNumber
                        ]
                    );
                } else {
                    $company->admin_id = $invitation->created_by;
                    $company->save();

                    $invitation->is_registered = true;
                    $invitation->status = 2;
                    $invitation->gstn = $gstNumber;
                    $invitation->save();
                }
                
        
                $address = explode(', ', $request->address);

                // Total parts
                $count = count($address);

                // Required fields
                $billing_address = [
                    'address'     => $address[0] ?? '',
                    'street2'     => '',
                    'city'        => $count >= 3 ? $address[$count - 3] : '',
                    'state'       => $count >= 2 ? $address[$count - 2] : '',
                    'state_code'  => '',
                    'zip'         => $count >= 1 ? $address[$count - 1] : '',
                    'country'     => 'India'
                ];
                    // 'city'        => $address[$count - 3] : '',
                    // 'zip'         => $address[$count - 1] ?? '',
                    // 'state'       => $address[$count - 2] ?? '',

                // Handle street2 (middle elements)
                if ($count > 4) {
                    // From index 1 up to count-4
                    $street2Parts = array_slice($address, 1, $count - 4);
                    $billing_address['street2'] = implode(', ', $street2Parts);
                }

                $zohoPayload = [
                    'contact_name'        => $request->director_name,
                    'company_name'        => $request->company_name,
                    'contact_type'        => 'customer',
                    'customer_sub_type'   => 'business',
                    'gst_no'              => strtoupper($request->gstn),
                    'gst_treatment'       => 'business_gst',
                    'contact_persons'     => [],
                    'billing_address'     => $billing_address,
                    'shipping_address'     => $billing_address
                ];


                // Add Additional Contact Persons
                foreach ($request->contact as $contact) {
                    $nameParts = explode(' ', $contact['name'], 2);
                    $zohoPayload['contact_persons'][] = [
                        'salutation'          => '',
                        'first_name'          => $nameParts[0] ?? '',
                        'last_name'           => $nameParts[1] ?? '',
                        'email'               => $contact['email'],
                        'phone'               => $contact['mobile'],
                        'mobile'              => $contact['mobile'],
                        // 'is_primary_contact'  => false,
                        'enable_portal'       => false
                    ];
                }

                $nameParts = explode(' ', $request->director_name, 2);
                $zohoPayload['contact_persons'][] = [
                    'salutation'          => '',
                    'first_name'          => $nameParts[0] ?? '',
                    'last_name'           => $nameParts[1] ?? '',
                    'email'               => $request->email,
                    'mobile'              => $request->mobile_number,
                    'phone'               => '',
                    'is_primary_contact'  => true,
                    'enable_portal'       => false
                ];

                $response = $zoho->createCustomer($zohoPayload);
                if (!isset($response['code']) || $response['code'] != 0) {
                    throw new \Exception('Zoho customer creation failed: ' . ($response['message'] ?? 'Unknown error'));
                }

                $contact = $response['contact'] ?? null;
                $company->zoho_contact_id = $contact['contact_id'];
                $company->save();

                foreach($contact['contact_persons'] as $person){
                    $firstName = $person['first_name'] ?? '';
                    $lastName  = $person['last_name'] ?? '';
                    $name      = trim($firstName . ' ' . $lastName);

                    $email         = $person['email'] ?? null;
                    $mobileRaw     = $person['mobile'] ?? null;
                    $phoneRaw      = $person['phone'] ?? null;
                    $designation   = $person['designation'] ?? null;
                    $isPrimaryZoho = $person['is_primary_contact'] ?? false;
                    $contactPersonId = $person['contact_person_id'] ?? null;   // if Zoho sends this

                    $normalizedMobile = $company->normalizeMobile($mobileRaw);
                    $normalizedPhone  = $company->normalizeMobile($phoneRaw);

                    if (empty($normalizedMobile) && empty($normalizedPhone)) {
                        continue;
                    }

                    $isPrimary = $isPrimaryZoho ? 1 : 0;

                    $data = [
                        'contact_person_id' => $contactPersonId,
                        'name'              => !empty($name) ? $name : null,
                        'email'             => !empty($email) ? $email : null,
                        'mobile'            => !empty($normalizedMobile) ? $normalizedMobile : null,
                        'phone'             => !empty($normalizedPhone) ? $normalizedPhone : null,
                        'designation'       => !empty($designation) ? $designation : null,
                        'is_primary'        => $isPrimary,
                    ];

                    Log::info("new customer company contacts details from zoho contacts", ['gst' => $company->gstn, 'data' => $data]);

                    $company->contact()->updateOrCreate(
                        ['contact_person_id' => $contactPersonId],
                        $data
                    );
                }

                if ($perfiosResult['success'] && !empty($perfiosResult['data']['result'])) {
                    $results   = $perfiosResult['data']['result'] ?? [];
                    foreach ($results as $item) {
                        $gstin = strtoupper($item['gstinId'] ?? '');
                        if (empty($gstin)) continue;

                        ClientGstin::updateOrCreate(
                            ['zoho_contact_id' => $zohoId, 'gstin' => $gstin],
                            [
                                'pan_number' => $panNumber,
                                'auth_status'         => !empty($item['authStatus']) ? $item['authStatus'] : null,
                                'application_status'  => !empty($item['applicationStatus']) ? $item['applicationStatus'] : null,
                                'email_id'            => !empty($item['emailId']) ? $item['emailId'] : null,
                                'gstin_ref_id'        => !empty($item['gstinRefId']) ? $item['gstinRefId'] : null,
                                'mob_num'             => !empty($item['mobNum']) ? $item['mobNum'] : null,
                                'reg_type'            => !empty($item['regType']) ? $item['regType'] : null,
                                'state'               => !empty($item['state']) ? $item['state'] : null
                            ]
                        );
                    }
                }
            });
            try {
            // ✅ Prepare mail data
                $subject = 'Registration Successful – Awaiting Verification';
                $viewFile = 'mail-template.client-registration-completed';
                $response = MailHelper::send($request->email, $subject, $viewFile);

                // ✅ Send mail
                if (!$response['status']) {
                    Log::error("Error Client Registration mail failed for {$request->email}: " . $response['message']);
                }else{
                    Log::info("Client Registration mail send successfully to - {$request->email} :-" . strtoupper($request->gstn));
                }

            } catch (\Throwable $loopEx) {
                Log::error("Error processing Client Registration  for {$request->email}: " . $loopEx->getMessage(), [
                    'trace' => $loopEx->getTraceAsString(),
                ]);
            }
            session([
                'access_status' => true,
                'status_type' => 'registered'
            ]);
            return redirect()->route('welcome');
        }catch (\Illuminate\Validation\ValidationException $e) {

            Log::error('Validation failed for company registration', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        }
        catch (\Exception $e) {
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
