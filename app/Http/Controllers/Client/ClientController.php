<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\GlobalController;
use App\Models\ClientCompany;
use App\Models\ClientCompanyAuthorizedPerson;
use App\Models\ClientCompanyContact;
use App\Models\ClientGstDetail;
use App\Models\PurchaseOrderItem;
use App\Models\SalesOrderItem;
use App\Models\SalesOrderInvoice;
use App\Services\ZohoBookService;
use App\Models\SalesOrder;
use App\Models\Project;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClientController extends GlobalController
{
    public function __construct()
    {
        $this->middleware('client', ['except' => ['checkGst', 'checkcin', 'showClientRegisterForm', 'postRegister']]);
    }

    public function showClientRegisterForm()
    {
        return view('client.auth.register');
    }

    public function postRegister(Request $request)
    {

        $uuid = (string) Str::uuid();

        $company = new ClientCompany;
        $company->uuid = $uuid;
        if (isset($request->logo)) {
            $fileName = $this->uploadImage($request->logo, 'company/' . $uuid);
            $company->company_logo = $fileName;
        }
        $company->company_name = $request->name;
        $company->email = $request->email;
        $company->gstn = strtoupper($request->gstn);
        $company->cin = $request->cin;
        $company->pan_number = strtoupper($request->pan_number);
        $company->password = $request->password;
        $company->save();

        $client = ClientCompany::where('id', $company->id)->first();

        Auth::guard('client')->login($client);

        return redirect(route('client.dashboard'))->with('messages', [
            [
                'type' => 'success',
                'title' => 'Client Company',
                'message' => 'Client company successfully added',
            ],
        ]);
    }

    public function index()
    {

        $user = Auth::guard('client')->user();

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
                ->whereHas('salesOrder', fn($q) => $q->where('customer_id', $user->zoho_contact_id))
                ->orderByDesc('id')
                ->get();

        $kycDetails = ClientCompany::with('gstDetails')
            ->select(['id', 'cin', 'cin_verify', 'is_verify', 'is_active', 'is_credit_req', 'is_auto_password', 'is_terms_accepted', 'turnover'])
            ->where('id', $user->id)
            ->first();

        $amount = [
            "0" => 'After Apply Unlock Your limit',
            "1" => '50,00,000',
            "2" => '1,00,00,000',
            "3" => '2,00,00,000',
            "4" => '3,00,00,000',
            "5" => '5,00,00,000',
        ];
        $kycDetails['credit_amount'] =  $amount[$kycDetails->turnover];

        $customerId = $user->zoho_contact_id;

        $data = [
            'total_projects' => Project::where('client_id', $user->id)
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
        return view('client.dashboard.dashboard', compact('kycDetails','data', 'items'));
    }

    public function acceptTerms(Request $request)
    {

        $client = ClientCompany::where('id', Auth::guard('client')->user()->id)->update(['is_terms_accepted' => 1]);

        return $client ? 'true' : 'false';
    }

    public function editCompanyProfile()
    {
        $detail = ClientCompany::with(['contact' => function ($query) { $query->where('is_primary', 0);}])
                                ->where('id', Auth::guard('client')->user()->id)
                                ->first();
        return view('client.dashboard.edit_profile', compact('detail'));
    }


    public function updateCompanyProfile(Request $request)
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

            return redirect()->route('client.dashboard')->with('messages', [[
                'type' => 'success',
                'message' => 'Client company successfully updated',
            ]]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {

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

    private function updateAuthorizedPersons($authorized, $companyId)
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

    public function changeClientPassword()
    {
        return view('client.dashboard.change_password');
    }

    public function updateClientPassword(Request $request)
    {

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        $clientId = Auth::guard('client')->user()->id;
        $client = ClientCompany::where('id', '=', $clientId)->first();

        $isMatchpPassword = false;
        if($client->is_auto_password == 1){
            if ($request->old_password == $client->uuid) {
                $isMatchpPassword = true;
            }
        }else{
            if (Hash::check($request->old_password, $client->password)) {
                $isMatchpPassword = true;
            }
        }
        if ($isMatchpPassword) {

            if ($request->new_password === $request->confirm_password) {

                $client->password = Hash::make($request->new_password);
                if ($client->is_auto_password == 1 && url()->previous() == route('client.dashboard')) {
                    $client->is_auto_password = 0;
                }
                $client->save();

                return redirect()->route('client.dashboard')->with('messages', [
                    [
                        'type' => 'success',
                        'title' => 'Password Updated',
                        'message' => 'Your password has been successfully updated.',
                    ],
                ]);
            } else {
                return redirect()->back()->with('messages', [
                    [
                        'type' => 'error',
                        'title' => 'Password Mismatch',
                        'message' => 'The new password and confirm password do not match. Please try again.',
                    ],
                ]);
            }
        } else {

            return redirect()->back()->with('messages', [
                [
                    'type' => 'error',
                    'title' => 'Invalid Current Password',
                    'message' => 'The current password you entered is incorrect. Please check and try again.',
                ],
            ]);
        }
    }

    public function checkGst(Request $request)
    {

        $gst = ClientCompany::where('gstn', $request->gstn)->first();

        return !is_null($gst) ? 'false' : 'true';
    }

    public function checkcin(Request $request)
    {

        $cin = ClientCompany::where('cin', $request->cin)->first();

        return !is_null($cin) ? 'false' : 'true';
    }
}
