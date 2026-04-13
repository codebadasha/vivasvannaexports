<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DefaultResponse;
use Illuminate\Http\Request;
use App\Helpers\MailHelper;
use App\Http\Controllers\GlobalController;
use App\Models\Admin;
use App\Models\ClientCompanyAuthorizedPerson;
use App\Models\ClientCompanyContact;
use App\Models\ClientCompany;
use App\Models\ClientGstDetail;
use App\Models\ClientGstin;
use App\Models\CompanyTeamMember;
use App\Models\PurchaseOrderItem;
use App\Models\ClientInvestor;
use App\Models\SalesOrderItem;
use App\Services\PerfiosService;
use App\Services\SurepassService;
use App\Services\ZohoBookService;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
// use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use App\Models\Module;
use App\Models\RoleModule;
use App\Models\Project;
use App\Models\SalesOrder;
use App\Models\SalesOrderInvoice;
use Illuminate\Support\Facades\Auth;

class ClientCompanyController extends GlobalController
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $filter = 0;

        $query = ClientCompany::with([
            'gstDetails' => function ($q) {$q->select('client_company_id','constitution_of_business');}
            ])->select(['id','company_name','director_name','gstn','pan_number','cin','cin_verify','msme_register','turnover','is_active','address','is_verify'])->where('is_delete', 0);

        $user = Auth::guard('admin')->user();

        $module = Module::where('key', 'client-company')->first();

        $permission = RoleModule::where('role_id', $user->role_id)
            ->where('module_id', $module->id ?? null)
            ->first();

        $actions = $permission
            ? array_map('trim', explode(',', $permission->action))
            : [];

        if (!in_array($user->user_role, ['Super Admin', 'admin'])) {

            $query->where(function ($q) use ($user, $actions) {

                // admin condition
                $q->where('admin_id', $user->id);

                // OR verify condition
                if (in_array('verify', $actions) && (!$request->has('verify') || $request->verify === 'all' || $request->verify == '')) {
                    $q->orWhere('is_verify', 0);
                }

            });
        }

        if (isset($request->gstin) && $request->gstin != '') {
            $filter = 1;
            $query->where('gstin', 'LIKE', '%' . $request->gstin . '%');
        }

        if (isset($request->pan) && $request->pan != '') {
            $filter = 1;
            $query->where('pan_number', 'LIKE', '%' . $request->pan . '%');
        }

        if (isset($request->client)) {
            $filter = 1;
            $query->where('id', $request->client);
        }

        if (isset($request->status)) {
            if($request->status != 'all'){
                $filter = 1;
                // $status = $request->status == 2 ? 0 : 1;
                $query->where('is_active', $request->status);
            }
        }

        if (isset($request->verify)) {
            if($request->verify != 'all'){
                $filter = 1;
                $query->where('is_verify', $request->verify);
            }
        }
        // $query->where('is_verify', 1);
        $client = $query->orderByDesc('zoho_contact_id')->get();

        $allClientQuery = ClientCompany::query();
        if (!in_array($user->user_role, ['Super Admin', 'admin'])) {
            $allClientQuery->where('admin_id', $user->id);
        }
      
        $allCilents = $allClientQuery->get();

        $admins = Admin::whereNot('user_role', 'Super Admin')->where('is_active', 1)->get(['id', 'name']);

        return view('admin.company.list', compact('client', 'admins', 'filter', 'allCilents'));
    }

    public function create()
    {
        return view('admin.company.add');
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

    public function store(Request $request, SurepassService $surepass, ZohoBookService $zoho, PerfiosService $perfios)
    {
        try {

            $request->validate([
                'company_name'   => 'required|string|max:255',
                'director_name'  => 'required|string|max:255',
                'pan_number'     => 'required|string|max:10|min:10',
                'gstn'           => 'required|string|size:15',
                'state_id'       => 'required|integer',
                'turnover'       => 'required|integer',
                'mobile_number'  => 'required|digits:10',
                'email'          => 'required|email|max:255',
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

            $panNumber = strtoupper($request->pan_number);
            
            $msmeCheck = $surepass->msmeVerification($panNumber);
            $msme_register = 0; // default = not MSME
            if ($msmeCheck['status']) {
                $msmeData = $msmeCheck['data'] ?? [];

                if (!empty($msmeData['udyam_exists']) && $msmeData['udyam_exists'] === true) {
                    $msme_register = 1;
                }
            }

            $user = Auth::guard('admin')->user();
            DB::transaction(function () use ($perfios, $zoho, $request, $panNumber, $msme_register, $user) {
                $uuid = (string) Str::uuid();

                $companyData = [
                    'uuid' => $uuid,
                    'company_name' => $request->company_name,
                    'address' => $request->address,
                    'state_id' => $request->state_id,
                    'director_name' => $request->director_name,
                    'mobile_number' => $request->mobile_number,
                    'email' => $request->email,
                    'password' => bcrypt($uuid),
                    'gstn' => strtoupper($request->gstn),
                    'pan_number' => $panNumber,
                    'cin' => $request->cin,
                    'cin_verify' => $request->cin !== null ? 1 : 0,
                    'msme_register' => $msme_register,
                    'turnover' => $request->turnover,
                    'is_auto_password' => 1,
                    'is_verify' => 0,
                    'is_active' => 0,
                ];

                if ($user->user_role !== 'Super Admin') {
                    $companyData['admin_id'] = $user->id;
                }

                $company = ClientCompany::updateOrCreate(
                    ['gstn' => strtoupper($request->gstn)],
                    $companyData
                );

                $companyGstDetails = ClientGstDetail::where('gstn', $request->gstn)->first();
                if ($companyGstDetails) {
                    $companyGstDetails->client_company_id = $company->id;
                    $companyGstDetails->save();
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

                $perfiosResult = $perfios->searchGstByPan($panNumber);

                if (!$perfiosResult['success'] && !empty($perfiosResult['data']['result']) || is_array($perfiosResult['data']['result'])) {
                    $results   = $perfiosResult['data']['result'] ?? [];
                    foreach ($results as $item) {
                        $gstin = strtoupper($item['gstinId'] ?? '');
                        if (empty($gstin)) continue;
                        
                        ClientGstin::updateOrCreate(
                            ['gstin' => $gstin, 'client_company_id' => $company->id],
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
                Log::error("Error processing invitation for {$email}: " . $loopEx->getMessage(), [
                    'trace' => $loopEx->getTraceAsString(),
                ]);
            }
            
            $route = $request->btn_value === 'save_and_update' ? 'admin.client.create' : 'admin.client.index';

            return redirect(route($route))->with('messages', [['type' => 'success', 'message' => 'Client company successfully added',]]);
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

    public function edit($id)
    {
        $detail = ClientCompany::with(['contact' => function ($query) { $query->where('is_primary', 0);}])
                                ->where('id', base64_decode($id))
                                ->first();
        return view('admin.company.edit', compact('detail'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'company_name'   => 'required|string|max:255',
                'director_name'  => 'required|string|max:255',
                'state_id'       => 'required|integer',
                'turnover'       => 'required|integer',
                'mobile_number'  => 'required|digits:10',
                'email'          => 'required|email|max:255',
                'cin'            => 'nullable|string|max:21',

                'contact' => 'required|array|min:1',

                'contact.*.name' => 'required|string|max:255',
                'contact.*.email' => 'required|email|max:255',
                'contact.*.mobile' => 'required|digits:10',
                'contact.*.phone' => 'nullable|digits:10',
                'contact.*.designation' => 'nullable|string',

            ],[], 
            [
                // ✅ Attribute rename (IMPORTANT 🔥)
                'contact.*.email' => 'Email',
                'contact.*.mobile' => 'Mobile number',
                'contact.*.name' => 'Name',
            ]);

            // ✅ Duplicate check (server side)
            $emails = [];
            $mobiles = [];

            foreach ($request->contact as $k => $c) {

                if (in_array($c['email'], $emails) || $c['email'] == $request->email) {
                    return back()->withErrors([
                        "contact.$k.email" => "Duplicate email not allowed"
                    ])->withInput();
                }

                if (in_array($c['mobile'], $mobiles) || $c['mobile'] == $request->mobile_number) {
                    return back()->withErrors([
                        "contact.$k.mobile" => "Duplicate mobile not allowed"
                    ])->withInput();
                }

                $emails[] = $c['email'];
                $mobiles[] = $c['mobile'];
            }

            DB::transaction(function () use ($request) {

                $company = ClientCompany::findOrFail($request->id);

                $company->update([
                    'company_name'   => $request->company_name,
                    'address'        => $request->address,
                    'state_id'       => $request->state_id,
                    'director_name'  => $request->director_name,
                    'mobile_number'  => $request->mobile_number,
                    'email'          => $request->email,
                    'cin'            => $request->cin,
                    'turnover'       => $request->turnover,
                ]);

                if (!empty($request->contact)) {
                    $this->updateContacts($request->contact, $company);
                }
                $company->save();
            });

            return redirect()->route('admin.client.index')->with('messages', [[
                'type' => 'success',
                'message' => 'Client company successfully updated',
            ]]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for company registration', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Client company update failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('messages', [[
                    'type' => 'error',
                    'message' => $e->getMessage()
                ]]);
        }
    }
    
    private function updateContacts($contacts, $company)
    {          
        $contactId = $company->zoho_contact_id;
        $zoho = new ZohoBookService();
        foreach ($contacts as $contact) {
            
            $status = $contact['status'] ?? null;

            if (empty($status)) {
                continue;
            }

            if ($status === 'add') {
                $zohoPayload = [
                    'contact_id'    => $contactId,
                    'first_name'    => $contact['name'],
                    'email'         => $contact['email'],
                    'mobile'        => $contact['mobile'],
                    "phone"         => $contact['phone'],
                    "designation"   => $contact['designation']
                ];

                try {
                    $zohoResponse = $zoho->CreateCustomerContact($zohoPayload);

                    $contact['contact_person_id'] = $zohoResponse['contact_person']['contact_person_id'] ?? null;

                    if (empty($contact['contact_person_id'])) {
                        throw new \Exception('Zoho contact person ID not returned on create.');
                    }

                    Log::info('Zoho Contact Person Created', [
                        'company_id' => $company->id,
                        'zoho_contact_person_id' => $contact['contact_person_id']
                    ]);

                } catch (\Exception $e) {
                    Log::error('Failed to create contact person in Zoho', [
                        'company_id' => $company->id,
                        'payload' => $zohoPayload,
                        'error' => $e->getMessage()
                    ]);

                    throw new \Exception('Failed to update or create new contact');
                }

                unset($contact['status']);

                $company->contact()->updateOrCreate(
                    ['contact_person_id' => $contact['contact_person_id']],
                    $contact
                );
            }

            if($status === 'edit'){

                $zohoPayload = [
                    'contact_id'    => $contactId,
                    'first_name'    => $contact['name'] ?? null,
                    'email'         => $contact['email'] ?? null,
                    'mobile'        => $contact['mobile'] ?? null,
                    'phone'         => $contact['phone'] ?? null,
                    'designation'   => $contact['designation'] ?? null,
                ];

                try {
                    $zoho->UpdateCustomerContact($contact['contact_person_id'], $zohoPayload);

                    Log::info('Zoho Contact Person Updated', [
                        'company_id' => $company->id,
                        'zoho_contact_person_id' => $contact['contact_person_id']
                    ]);

                } catch (\Exception $e) {
                    Log::error('Failed to update contact person in Zoho', [
                        'company_id' => $company->id,
                        'payload' => $zohoPayload,
                        'error' => $e->getMessage()
                    ]);

                    throw new \Exception('Failed to update or create new contact');
                }

                unset($contact['status']);

                $company->contact()->updateOrCreate(
                    ['contact_person_id' => $contact['contact_person_id']],
                    $contact
                );
            }
        }

        $primaryContact = ClientCompanyContact::where('client_company_id', $company->id)
        ->where('is_primary', 1)
        ->first();

        if (!empty($primaryContact)) {

            if (
                $primaryContact->mobile != $company->mobile_number ||
                $primaryContact->email != $company->email ||
                $primaryContact->name != $company->director_name
            ) {
                $contactPersonId = $primaryContact->contact_person_id;
                Log::info('Primary Zoho Contact exitting', [
                        'company_id' => $company->id,
                        'zoho_contact_person_id' => $contactPersonId
                    ]);

                $zohoPayload = [
                    'contact_id'    => $contactId,
                    'first_name'    => $company->director_name,
                    'email'         => $company->email,
                    'mobile'        => $company->mobile_number,
                ];

                try {
                    $zoho->UpdateCustomerContact($contactPersonId, $zohoPayload);

                    Log::info('Primary Zoho Contact Updated', [
                        'company_id' => $company->id,
                        'zoho_contact_person_id' => $contactPersonId
                    ]);

                    $contact = [
                        'contact_person_id' => $contactPersonId,
                        'name'              => $company->director_name,
                        'email'             => $company->email,
                        'mobile'            => $company->mobile_number,
                        'is_primary'        => 1,
                    ];

                    $company->contact()->updateOrCreate(
                        ['contact_person_id' => $contact['contact_person_id']],
                        $contact
                    );

                } catch (\Exception $e) {
                    Log::error('Failed to update primary contact in Zoho', [
                        'company_id' => $company->id,
                        'payload' => $zohoPayload,
                        'error' => $e->getMessage()
                    ]);

                    throw new \Exception('Failed to update primary contact: ' . $e->getMessage());
                }
            }

        } else {
            Log::info('Primary Zoho Contact not exitting', [
                        'company_id' => $company->id,
                    ]);
            $zohoPayload = [
                'contact_id'    => $contactId,
                'first_name'    => $company->director_name,
                'email'         => $company->email,
                'mobile'        => $company->mobile_number,
            ];

            $contactPersonId = '';
            $is_primary = 0;

            try {
                $zohoResponse = $zoho->CreateCustomerContact($zohoPayload);
                $contactPersonId = $zohoResponse['contact_person']['contact_person_id'] ?? null;

                if (empty($contactPersonId)) {
                    throw new \Exception('Zoho contact person ID not returned for primary contact.');
                }

                $zoho->setPrimaryCustomerContact($contactPersonId);
                $is_primary = '1';

                $contact = [
                    'contact_person_id' => $contactPersonId,
                    'name'              => $company->director_name,
                    'email'             => $company->email,
                    'mobile'            => $company->mobile_number,
                    'is_primary'        => $is_primary,
                ];

                $company->contact()->updateOrCreate(
                    ['contact_person_id' => $contact['contact_person_id']],
                    $contact
                );

                Log::info('Primary Zoho Contact Created', [
                    'company_id' => $company->id,
                    'zoho_contact_person_id' => $contactPersonId
                ]);

            } catch (\Exception $e) {
                Log::error('Failed to create/set primary contact in Zoho', [
                    'company_id' => $company->id,
                    'payload' => $zohoPayload,
                    'error' => $e->getMessage()
                ]);

                throw new \Exception('Failed to create/set primary contact in Zoho: ' . $e->getMessage());
            }

        }
    }

    public function updateAuthorizedPersons($authorized, $companyId)
    {
        ClientCompanyAuthorizedPerson::where('client_company_id', $companyId)->delete();
        foreach ($authorized as $person) {
            ClientCompanyAuthorizedPerson::create([
                'client_company_id' => $companyId,
                'name'              => $person['name'],
                'email'             => $person['email'],
                'mobile'            => $person['mobile'],
            ]);
        }
    }

    /**
     * Update Investors
     */
    private function updateInvestors($investors, $companyId)
    {
        ClientInvestor::where('client_id', $companyId)->delete();
        foreach ($investors as $investorId) {
            ClientInvestor::create([
                'client_id'   => $companyId,
                'investor_id' => $investorId,
            ]);
        }
    }

    public function delete($id)
    {

        $deleteInvestor = ClientCompany::where('id', base64_decode($id))->update(['is_delete' => 1]);

        return redirect(route('admin.client.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Client Company',
                'message' => 'Client company successfully deleted',
            ],
        ]);
    }

    public function checkSupplierGst(Request $request)
    {

        $query = ClientCompany::where('gstn', $request->gstn);
        if (isset($request->id)) {
            $query->where('id', '!=', $request->id);
        }
        $email = $query->where('is_delete', 0)->first();

        return $email ? 'false' : 'true';
    }

    public function assignTeamMember($id)
    {

        $team = CompanyTeamMember::where('client_company_id', base64_decode($id))->pluck('admin_id')->toArray();

        return view('admin.company.team_member', compact('id', 'team'));
    }

    public function storeTeamMember(Request $request)
    {
        CompanyTeamMember::where('client_company_id', $request->id)->delete();

        if (!is_null($request->member)) {
            foreach ($request->member as $mk => $mv) {
                $team = new CompanyTeamMember;
                $team->client_company_id = $request->id;
                $team->admin_id = $mv;
                $team->save();
            }
        }

        return redirect(route('admin.client.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Client Company',
                'message' => 'Team member successfully assigend',
            ],
        ]);
    }

    public function downloadCompanyDocumentZip($companyId)
    {

        $document = ClientCompany::where('id', base64_decode($companyId))->first();

        $zip = new ZipArchive;
        $zipFileName = date('dmyhis') . ".zip";
        $zipFilePath = storage_path($zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === true) {
            // Add files to the ZIP file
            $filesToAdd = [
                public_path('uploads/company/' . $document->uuid . '/' . $document->registration_cetificate),
                public_path('uploads/company/' . $document->uuid . '/' . $document->incorporation),
                public_path('uploads/company/' . $document->uuid . '/' . $document->gst_certificate),
                public_path('uploads/company/' . $document->uuid . '/' . $document->pan_card),
                public_path('uploads/company/' . $document->uuid . '/' . $document->aoa),
            ];

            foreach ($filesToAdd as $file) {
                $zip->addFile($file, basename($file));
            }

            $zip->close();
        }

        return Response::download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function getCompanyAuthorizedPerson(Request $request)
    {

        $getCompanyAuthorizedPerson = ClientCompanyAuthorizedPerson::where('client_company_id', $request->id)->get();

        $getClientCompanyContact = ClientCompanyContact::where('client_company_id', $request->id)->get();

        return view('admin.company.authorized_person', compact('getCompanyAuthorizedPerson', 'getClientCompanyContact'));
    }

    public function getCompanyContactPersons(Request $request)
    {
        $companyId = $request->id;

        $company = ClientCompany::select('id','company_name')->with('contact')->findOrFail($companyId);

        $contacts = $company->contact()
            ->orderBy('is_primary', 'desc')
            ->orderBy('name')
            ->get();

        return view('admin.company.contact_persons', compact('company', 'contacts'));
    }

    public function updateContactPerson(Request $request, ZohoBookService $zoho)
    {
        $contact = ClientCompanyContact::where('id', $request->id)->first();
 
        if (!$contact || !$contact->contact_person_id) {
            return response()->json([
                'status' => false,
                'message' => 'Contact not found.'
            ]);
        }
              
        $company = $contact->clientCompany;

        if (!$company || !$company->zoho_contact_id) {
            return response()->json([
                'status' => false,
                'message' =>'Contact not found.'
            ]);
        }

        // Validation
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email',
            'mobile'      => 'required|string',
            'phone'       => 'nullable|string',
            'designation' => 'nullable|string|max:255',
            // 'is_primary'  => 'nullable|boolean',
        ]);

        // Prepare payload for Zoho
        $zohoPayload = [
            'contact_id'   => $company->zoho_contact_id,
            'first_name'   => $data['name'],
            'email'        => $data['email'] ?? null,
            'mobile'       => $data['mobile'],
            'designation'  => $data['designation'] ?? null,
        ];

        // Step 1: Try updating in Zoho first
        try {
            $zohoResponse = $zoho->UpdateCustomerContact($contact->contact_person_id, $zohoPayload);
            Log::info('Zoho Contact Updated Successfully', [
                'contact_person_id' => $contact->contact_person_id,
                'zoho_response' => $zohoResponse
            ]);
        } 
        catch (\Exception $e) {
            Log::error('Zoho Contact Update Failed', [
                'contact_id' => $contact->id,
                'contact_person_id' => $contact->contact_person_id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to update contact. Please try again!'
            ]);
        }

        // Step 2: Only if Zoho succeeded, update local database
        try {
            $updateData = [
                'name'        => $data['name'],
                'email'       => $data['email'],
                'mobile'      => $data['mobile'],
                'phone'       => $data['phone'],
                'designation' => $data['designation'],
            ];

            $contact->update($updateData);

            return response()->json([
                'status' => true,
                'message' => 'Contact updated successfully'
            ]);
        } 
        catch (\Exception $e) {
            Log::error('Local database update failed after Zoho success', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to update contact. Please try again!'
            ]);
        }
    }

    public function deleteContactPerson(Request $request, ZohoBookService $zoho)
    {
       
        $contact = ClientCompanyContact::where('id', $request->id)->first();

        if (!$contact || !$contact->contact_person_id) {
            return response()->json([
                'status' => false,
                'message' => 'Contact not found.'
            ]);
        }
              
        $company = $contact->clientCompany;

        if (!$company || !$company->zoho_contact_id) {
            return response()->json([
                'status' => false,
                'message' =>'Contact not found.'
            ]);
        }

        // Delete from Zoho first
        try {
            $zohoResponse = $zoho->deleteCustomerContact($contact->contact_person_id);
            Log::info('Zoho Contact deleted Successfull', [
                'contact_person_id' => $contact->contact_person_id,
                'zoho_response' => $zohoResponse
            ]);
        } 
        catch (\Exception $e) {
            Log::error('Zoho Contact delete Failed', [
                'contact_id' => $contact->id,
                'contact_person_id' => $contact->contact_person_id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to delete contact. Please try again!'
            ]);
        }

        $contact->delete();

        return response()->json(['status' => true, 'message' => 'Contact has been deleted successfully']);
    }

    public function setPrimaryContact(Request $request, ZohoBookService $zoho)
    {
        $contact = ClientCompanyContact::where('id', $request->id)->first();

        if (!$contact || !$contact->contact_person_id) {
            return response()->json([
                'status' => false,
                'message' => 'Contact not found.'
            ]);
        }
              
        $company = $contact->clientCompany;

        if (!$company || !$company->zoho_contact_id) {
            return response()->json([
                'status' => false,
                'message' =>'Contact not found.'
            ]);
        }
        
        try {

            $zohoResponse = $zoho->setPrimaryCustomerContact($contact->contact_person_id);
            Log::info('Zoho Contact set Primary Successfull', [
                'contact_person_id' => $contact->contact_person_id,
                'zoho_response' => $zohoResponse
            ]);
        } 
        catch (\Exception $e) {
            Log::error('Zoho Contact set Primary Failed', [
                'contact_id' => $contact->id,
                'contact_person_id' => $contact->contact_person_id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to set Primary contact. Please try again!'
            ]);
        }

        // Reset all to 0
        ClientCompanyContact::where('client_company_id', $contact->client_company_id)
            ->update(['is_primary' => 0]);

        // Set new one as primary
        $contact->update(['is_primary' => 1]);

        return response()->json([
            'status' => true,
            'message' => 'Primary contact updated successfully'
        ]);
    }

    public function overdueIntrestSetting(Request $request)
    {

        $getIntresetData = ClientCompany::where('id', $request->id)->first();

        return view('admin.company.tax_setting', compact('getIntresetData'));
    }

    public function updateTaxSetting(Request $request)
    {

        $company = ClientCompany::findOrFail($request->id);
        $company->credit_amount = $request->credit_amount;
        $company->interest_rate = $request->interest_rate;
        $company->tolerance = $request->tolerance;
        $company->save();

        return redirect(route('admin.client.index'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Client Company',
                'message' => 'Tax setting successfully updated',
            ],
        ]);
    }

    public function changeCompanyStatus(Request $request)
    {
        $company = ClientCompany::find($request->id);

        if (!$company) {
            return response()->json(DefaultResponse::error('Company not found'));
        }

        // update only is_active
        $company->is_active = $request->option;
        $company->save();

        if ($request->option == 1) {
            return response()->json(DefaultResponse::success(null, 'Company has been successfully activated'));
        }

        return response()->json(DefaultResponse::success(null, 'Company has been successfully deactivated'));
    }

    public function verifyCompany(Request $request)
    {
        $companyId = base64_decode($request->id);

        $company = ClientCompany::with(['gstDetails', 'contact', 'authorized'])
            ->find($companyId);

        if (!$company) {
            return response()->json([
                'status' => false,
                'message' => 'Company not found.'
            ]);
        }

        $pending = [];

        // Check Company Email
        if (empty($company->email) || !filter_var($company->email, FILTER_VALIDATE_EMAIL)) {
            $pending[] = 'Email';
        }

        if (empty($company->mobile_number) || !filter_var($company->email, FILTER_VALIDATE_EMAIL)) {
            $pending[] = 'Mobile number';
        }

        // Check CIN
        $constitution = optional($company->gstDetails)->constitution_of_business;
        if (
            empty($company->cin) &&
            $constitution &&
            !in_array($constitution, ['Proprietorship', 'Partnership'])
        ) {
            $pending[] = 'CIN';
        }

        // Check Authorised Person
        // $authValid = $company->authorized->isNotEmpty() && 
        //             $company->authorized->every(function ($person) {
        //                 return !empty($person->name) && !empty($person->email) && !empty($person->mobile);
        //             });

        // if (!$authValid) {
        //     $pending[] = 'Authorised Person';
        // }

        // Check Contact Person
        $contactValid = $company->contact->isNotEmpty() && 
                        $company->contact->every(function ($person) {
                            return !empty($person->name) && !empty($person->email) && !empty($person->mobile);
                        });

        if (!$contactValid) {
            $pending[] = 'Contact Person';
        }

        // If any field is pending → show single short message
        if (!empty($pending)) {
            $pendingFields = implode(', ', $pending);
            return response()->json([
                'status' => false,
                'message' => "{$pendingFields} pending. Please complete company data for verification."
            ]);
        }

        // ====================== All Checks Passed - Verify Company ======================
        $company->update([
            'is_verify'    => 1,
            'is_active'    => 1,
            'verify_by_id' => auth()->id()
        ]);

        // Send Approval Email
        try {
            $subject = 'Account Approved – Full Access Granted!';
            $viewFile = 'mail-template.client-verification-completed';
            $data = [
                'gst_number' => strtoupper($company->gstn ?? ''),
                'password'   => $company->uuid,
            ];

            $response = MailHelper::send($company->email, $subject, $viewFile, $data);

            if (!$response['status']) {
                Log::error("Verification mail failed for company ID {$company->id}");
            } else {
                Log::info("Verification mail sent successfully to {$company->email}");
            }
        } catch (\Throwable $ex) {
            Log::error("Exception while sending verification mail for company ID {$company->id}: " . $ex->getMessage());
        }

        return response()->json([
            'status'  => true,
            'message' => 'Company verified successfully.'
        ]);
    }

    public function assignAndVerifyCompany(Request $request)
    {
        $decodedCompanyId = base64_decode($request->company_id);

        $request->merge(['company_id' => $decodedCompanyId]);

        $request->validate([
            'company_id' => 'required|exists:client_companies,id',
            'admin_id'   => 'required|exists:admins,id',
        ]);

        $company = ClientCompany::with(['gstDetails', 'contact', 'authorized'])
            ->find($request->company_id);

        if (!$company) {
            return response()->json([
                'status' => false,
                'message' => 'Company not found.'
            ]);
        }

        $pending = [];

        // Company Email
        if (empty($company->email) || !filter_var($company->email, FILTER_VALIDATE_EMAIL)) {
            $pending[] = 'Email';
        }

        if (empty($company->mobile_number) || !filter_var($company->email, FILTER_VALIDATE_EMAIL)) {
            $pending[] = 'Mobile number';
        }

        // CIN
        $constitution = optional($company->gstDetails)->constitution_of_business;
        if (
            empty($company->cin) &&
            $constitution &&
            !in_array($constitution, ['Proprietorship', 'Partnership'])
        ) {
            $pending[] = 'CIN';
        }

        // Authorized Person
        // $authValid = false;
        // if (!$company->authorized->isEmpty()) {
        //     $authValid = $company->authorized->every(function ($person) {
        //         return !empty($person->name) && !empty($person->email) && !empty($person->mobile);
        //     });
        // }
        // if (!$authValid) {
        //     $pending[] = 'Authorised Person';
        // }

        // Contact Person
        $contactValid = false;
        if (!$company->contact->isEmpty()) {
            $contactValid = $company->contact->every(function ($person) {
                return !empty($person->name) && !empty($person->email) && !empty($person->mobile);
            });
        }
        if (!$contactValid) {
            $pending[] = 'Contact Person';
        }

        // If anything is pending → show single short message
        if (!empty($pending)) {
            $pendingFields = implode(', ', $pending);
            return response()->json([
                'status' => false,
                'message' => "{$pendingFields} pending. Please complete company data for verification."
            ]);
        }

        // ====================== All Good - Verify Company ======================
        $company->update([
            'admin_id'     => $request->admin_id,
            'is_verify'    => 1,
            'is_active'    => 1,
            'verify_by_id' => auth()->id()
        ]);

        // Send Approval Email
        try {
            $subject = 'Account Approved – Full Access Granted!';
            $viewFile = 'mail-template.client-verification-completed';
            $data = [
                'gst_number' => strtoupper($company->gstn ?? ''),
                'password'   => $company->uuid,
            ];

            $response = MailHelper::send($company->email, $subject, $viewFile, $data);

            if (!$response['status']) {
                Log::error("Verification mail failed for company ID {$company->id}");
            }
        } catch (\Throwable $ex) {
            Log::error("Exception in verification mail: " . $ex->getMessage());
        }

        return response()->json([
            'status'  => true,
            'message' => 'Company verified and team member assigned successfully.'
        ]);
    }

    public function verifyCinNumber(Request $request)
    {
        $company = ClientCompany::find($request->id);

        if (!$company) {
            return response()->json(DefaultResponse::error('Company not found'));
        }

        $company->cin_verify = 1;
        $company->save();

        return response()->json(DefaultResponse::success(null, 'Company CIN number has been successfully verified.'));
    }

    public function clientDashboard($clientId)
    {

        $client = ClientCompany::where('id', base64_decode($clientId))->with(['contact', 'authorized'])->first();
        $customerId = $client->zoho_contact_id;
        $items = SalesOrderItem::query()
                ->with([
                    'salesOrder' => function ($q) {
                        $q->select('id', 'zoho_salesorder_id', 'salesorder_number', 'project_id', 'customer_id')
                        ->with([
                            'project' => fn($q) => $q->select('id', 'name'),
                            'invoices' => fn($q) => $q->select('id', 'sales_order_id')
                                ->with(['items' => fn($q) => $q->select('id', 'invoice_id', 'item_id', 'quantity')])
                        ]);
                    }
                ])
                ->whereHas('salesOrder', fn($q) => $q->where('customer_id', $customerId))
                ->orderByDesc('id')
                ->get();
        
        $data = [
            'total_projects' => Project::where('client_id', $client->id)
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->count(),

            'total_po_count' => SalesOrder::where('customer_id', $customerId)->count(),

            'total_po_amount' => SalesOrder::where('customer_id', $customerId)->sum('total'),

            'total_invoice_count' => SalesOrderInvoice::where('customer_id', $customerId)
                ->whereNotIn('status', ['draft','void','viewed'])
                ->count(),

            'total_invoice_amount' => SalesOrderInvoice::where('customer_id', $customerId)
                ->whereNotIn('status', ['draft','void','viewed'])
                ->sum('total'),

            'paid_invoice_count' => SalesOrderInvoice::where('customer_id', $customerId)
                ->where('status','paid')
                ->count(),

            'paid_invoice_amount' => SalesOrderInvoice::where('customer_id', $customerId)
                ->where('status','paid')
                ->sum('total'),

            'overdue_invoice_count' => SalesOrderInvoice::where('customer_id', $customerId)
                ->where('status','overdue')
                ->count(),

            'overdue_invoice_amount' => SalesOrderInvoice::where('customer_id', $customerId)
                ->where('status','overdue')
                ->sum('total'),
        ];

        return view('admin.company.dashboard', compact('client', 'items', 'data'));
    }

    public function getClientProjects($clientId)
    {
        $projects = Project::where('client_id', $clientId)->get(['id', 'name']);

        return response()->json([
            'projects' => $projects
        ]);
    }
}
