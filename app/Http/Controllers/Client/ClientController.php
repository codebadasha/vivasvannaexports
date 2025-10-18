<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\GlobalController;
use App\Models\ClientCompany;
use App\Models\ClientCompanyAuthorizedPerson;
use App\Models\ClientCompanyContact;
use App\Models\ClientGstDetail;
use App\Models\PurchaseOrderItem;
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

        $detail = PurchaseOrderItem::with(['po' => function ($q) {
            $q->with(['project', 'boq']);
        }, 'varation' => function ($q) {
            $q->with(['product']);
        }])
            ->whereHas('po', function ($q) {
                $q->where('client_id', Auth::guard('client')->user()->id);
            })
            ->get();
        $kycDetails = ClientCompany::select(['id', 'cin', 'cin_verify', 'is_credit_req', 'is_auto_password', 'is_terms_accepted', 'turnover'])->where('id', $user->id)->first();

        $amount = [
            "0" => 'After Apply Unlock Your limit',
            "1" => '50,00,000',
            "2" => '1,00,00,000',
            "3" => '2,00,00,000',
            "4" => '3,00,00,000',
            "5" => '5,00,00,000',
        ];
        $kycDetails['credit_amount'] =  $amount[$kycDetails->turnover];
        
        return view('client.dashboard.dashboard', compact('detail', 'kycDetails'));
    }

    public function acceptTerms(Request $request)
    {

        $client = ClientCompany::where('id', Auth::guard('client')->user()->id)->update(['is_terms_accepted' => 1]);

        return $client ? 'true' : 'false';
    }

    public function editCompanyProfile()
    {

        $detail = ClientCompany::where('id', Auth::guard('client')->user()->id)->first();

        return view('client.dashboard.edit_profile', compact('detail'));
    }

    public function updateCompanyProfile(Request $request)
    {
        try {
            $request->validate([
                'company_name'   => 'required|string|max:255',
                'director_name'  => 'required|string|max:255',
                'pan_number'     => 'required|string|max:10',
                'gstn'           => 'required|string|size:15',
                'state_id'       => 'required|integer',
                'mobile_number'  => 'required|digits:10',
                'email'          => 'required|email|max:255',
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
                'authorized.required' => 'At least one authorized person is required.',
                'contact.required' => 'At least one contact person is required.',
            ]);

            DB::transaction(function () use ($request) {
                $company = ClientCompany::findOrFail($request->id);

                $company->fill([
                    'company_name'   => $request->company_name,
                    'address'        => $request->address,
                    'state_id'       => $request->state_id,
                    'director_name'  => $request->director_name,
                    'mobile_number'  => $request->mobile_number,
                    'email'          => $request->email,
                    'gstn'           => strtoupper($request->gstn),
                    'cin'            => $request->cin,
                    'pan_number'     => strtoupper($request->pan_number),
                ]);
                $company->save();

                if (!empty($request->authorized)) {
                    $this->updateAuthorizedPersons($request->authorized, $company->id);
                }

                if (!empty($request->contact)) {
                    $this->updateContacts($request->contact, $company->id);
                }
            });
            return redirect(route('client.dashboard'))->with('messages', [[
                'type' => 'success',
                'message' => 'Profile successfully updated',
            ]]);
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Company not found', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->withErrors(['Company not found.']);
        } catch (\Exception $e) {
            Log::error('Something went wrong while saving company data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->withErrors(['Something went wrong: ' . $e->getMessage()]);
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

    /**
     * Update Contacts
     */
    private function updateContacts($contacts, $companyId)
    {
        ClientCompanyContact::where('client_company_id', $companyId)->delete();
        foreach ($contacts as $person) {
            ClientCompanyContact::create([
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
        if (Hash::check($request->old_password, $client->password)) {

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
