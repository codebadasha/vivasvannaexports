<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DefaultResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\GlobalController;
use App\Models\Admin;
use App\Models\ClientCompanyAuthorizedPerson;
use App\Models\ClientCompanyContact;
use App\Models\ClientCompany;
use App\Models\ClientGstDetail;
use App\Models\CompanyTeamMember;
use App\Models\PurchaseOrderItem;
use App\Models\ClientInvestor;
use App\Services\SurepassService;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class ClientCompanyController extends GlobalController
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $client = ClientCompany::where('is_delete', 0)->orderBy('id', 'desc')->get();
        return view('admin.company.list', compact('client'));
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

    public function store(Request $request, SurepassService $surepass)
    {

        try {

            $request->validate([
                'company_name'   => 'required|string|max:255',
                'director_name'  => 'required|string|max:255',
                'pan_number'     => 'required|string|max:10',
                'gstn'           => 'required|string|size:15',
                'state_id'       => 'required|integer',
                'turnover'       => 'required|integer',
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

            DB::transaction(function () use ($request, $panNumber, $msme_register) {
                $uuid = (string) Str::uuid();

                $companyData = [
                    'uuid' => $uuid,
                    'company_name' => $request->company_name,
                    'address' => $request->address,
                    'state_id' => $request->state_id,
                    'director_name' => $request->director_name,
                    'mobile_number' => $request->mobile_number,
                    'email' => $request->email,
                    'password' => bcrypt($request->gstn),
                    'gstn' => strtoupper($request->gstn),
                    'pan_number' => $panNumber,
                    'cin' => $request->cin,
                    'cin_verify' => $request->cin !== null ? 1 : 0,
                    'msme_register' => $msme_register,
                    'turnover' => $request->turnover,
                    'is_auto_password' => 1,
                    'is_verify' => 1,
                    'is_active' => 1,
                ];

                $company = ClientCompany::updateOrCreate(
                    ['gstn' => strtoupper($request->gstn)],
                    $companyData
                );

                $teamMember = Admin::select('id')->where('is_default', 1)->first() ?? Admin::select('id')->where('role_id', 4)->first();

                $team = new CompanyTeamMember;
                $team->client_company_id = $company->id;
                $team->admin_id = $teamMember->id;
                $team->save();

                $companyGstDetails = ClientGstDetail::where('gstn', $request->gstn)->first();
                if ($companyGstDetails) {
                    $companyGstDetails->client_company_id = $company->id;
                    $companyGstDetails->save();
                }

                if (!empty($request->authorized)) {
                    $this->updateAuthorizedPersons($request->authorized, $company->id);
                }

                if (!empty($request->contact)) {
                    $this->updateContacts($request->contact, $company->id);
                }
            });

            $route = $request->btn_value === 'save_and_update' ? 'admin.client.create' : 'admin.client.index';

            return redirect(route($route))->with('messages', [['type' => 'success', 'message' => 'Client company successfully added',]]);
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
        $detail = ClientCompany::with(['authorized', 'contact'])->where('id', base64_decode($id))->first();

        $investor = $detail->investor()->pluck('investor_id')->toArray();

        return view('admin.company.edit', compact('detail', 'investor'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'company_name'   => 'required|string|max:255',
                'director_name'  => 'required|string|max:255',
                'pan_number'     => 'required|string|max:10',
                'gstn'           => 'required|string|size:15',
                'state_id'       => 'required|integer',
                'turnover'       => 'required|integer',
                'mobile_number'  => 'required|digits:10',
                'email'       => 'required|email|max:255',
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
                    'turnover' => $request->turnover,
                ]);
                $company->save();

                if (!empty($request->authorized)) {
                    $this->updateAuthorizedPersons($request->authorized, $company->id);
                }

                if (!empty($request->contact)) {
                    $this->updateContacts($request->contact, $company->id);
                }

                if (!empty($request->investor)) {
                    $this->updateInvestors($request->investor, $company->id);
                }
            });
            return redirect(route('admin.client.index'))->with('messages', [[
                'type' => 'success',
                'message' => 'Client company successfully updated',
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

    // public function update(Request $request)
    // {

    //     $company = ClientCompany::findOrFail($request->id);
    //     if (isset($request->company_logo)) {
    //         $fileName = $this->uploadImage($request->company_logo, 'company/' . $request->uuid);
    //         $company->company_logo = $fileName;
    //     }
    //     $company->company_name = $request->company_name;
    //     $company->address = $request->address;
    //     $company->state_id = $request->state_id;
    //     $company->director_name = $request->director_name;
    //     $company->mobile_number = $request->mobile_number;
    //     $company->email = $request->email;
    //     $company->gstn = strtoupper($request->gstn);
    //     $company->cin = $request->cin;
    //     $company->pan_number = strtoupper($request->pan_number);
    //     if (isset($request->registration_cetificate)) {
    //         $fileName = $this->uploadImage($request->registration_cetificate, 'company/' . $request->uuid);
    //         $company->registration_cetificate = $fileName;
    //     }
    //     if (isset($request->incorporation)) {
    //         $fileName = $this->uploadImage($request->incorporation, 'company/' . $request->uuid);
    //         $company->incorporation = $fileName;
    //     }
    //     if (isset($request->gst_certificate)) {
    //         $fileName = $this->uploadImage($request->gst_certificate, 'company/' . $request->uuid);
    //         $company->gst_certificate = $fileName;
    //     }
    //     if (isset($request->pan_card)) {
    //         $fileName = $this->uploadImage($request->pan_card, 'company/' . $request->uuid);
    //         $company->pan_card = $fileName;
    //     }
    //     if (isset($request->aoa)) {
    //         $fileName = $this->uploadImage($request->aoa, 'company/' . $request->uuid);
    //         $company->aoa = $fileName;
    //     }
    //     $company->save();

    //     if (!is_null($request->authorized)) {
    //         ClientCompanyAuthorizedPerson::where('client_company_id', $request->id)->delete();
    //         foreach ($request->authorized as $ak => $av) {
    //             $authorized = new ClientCompanyAuthorizedPerson;
    //             $authorized->client_company_id = $company->id;
    //             $authorized->name = $av['name'];
    //             $authorized->email = $av['email'];
    //             $authorized->mobile = $av['mobile_number'];
    //             $authorized->save();
    //         }
    //     }

    //     if (!is_null($request->contact)) {
    //         ClientCompanyContact::where('client_company_id', $request->id)->delete();
    //         foreach ($request->contact as $ck => $cv) {
    //             $contact = new ClientCompanyContact;
    //             $contact->client_company_id = $company->id;
    //             $contact->name = $cv['name'];
    //             $contact->email = $cv['email'];
    //             $contact->mobile = $cv['mobile_number'];
    //             $contact->save();
    //         }
    //     }

    //     if (!is_null($request->investor)) {
    //         ClientInvestor::where('client_id', $request->id)->delete();
    //         foreach ($request->investor as $ck => $cv) {
    //             $contact = new ClientInvestor;
    //             $contact->client_id = $company->id;
    //             $contact->investor_id = $cv;
    //             $contact->save();
    //         }
    //     }

    //     return redirect(route('admin.client.index'))->with('messages', [
    //         [
    //             'type' => 'success',
    //             'title' => 'Client Company',
    //             'message' => 'Client company successfully updated',
    //         ],
    //     ]);
    // }


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

        $client = ClientCompany::where('id', base64_decode($clientId))->with(['contact'])->first();

        $detail = PurchaseOrderItem::with(['po' => function ($q) {
            $q->with(['project', 'boq']);
        }, 'varation' => function ($q) {
            $q->with(['product']);
        }])
            ->whereHas('po', function ($q) use ($clientId) {
                $q->where('client_id', base64_decode($clientId));
            })
            ->get();

        // echo "<pre>"                                   ;
        // print_r($detail->toArray());
        // exit;

        return view('admin.company.dashboard', compact('client', 'detail'));
    }
}
