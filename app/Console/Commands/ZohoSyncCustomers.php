<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\ClientCompany;
use App\Models\ClientCompanyAddress;
use App\Models\ClientCompanyAuthorizedPerson;
use App\Models\ClientCompanyContact;
use App\Models\ClientGstDetail;
use App\Models\CompanyTeamMember;
use App\Services\SurepassService;
use App\Services\ZohoBookService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ZohoSyncCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:sync:customers {--per_page=200}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Full sync of Zoho Customers into local DB (initial import)';

    /**
     * Execute the console command.
     */
    public function handle(ZohoBookService $zoho, SurepassService $surepass)
    {
        $this->info('Starting Zoho Customers sync...');
        $perPage = (int)$this->option('per_page') ?: 200;
        $page = 1;
        $totalImported = 0;

        do {
            $this->info("Fetching page {$page}...");

            $resp = $zoho->getAllCustomer([
                'page'     => $page,
                'per_page' => $perPage,
            ]);

            $customers = $resp['contacts'] ?? [];

            if (empty($customers)) {
                $this->info("No customers found on page {$page}, stopping.");
                break;
            }

            foreach ($customers as $customer) {

                $response = $surepass->verificationProcess($customer['gst_no']);
                $data = $response->getData(true);

                if (empty($data['data'])) {
                    Log::warning('Surepass returned no data for GST', [
                        'gst_no' => $customer['gst_no'] ?? null,
                        'response' => $data,
                    ]);
                    continue;
                }
                $request = $data['data'];
                $panNumber = strtoupper($request['pan_number']);

                $resp = $zoho->getCustomer($customer['contact_id']);
                $customerDetails =  $resp["contact"];

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
                DB::transaction(function () use ($request, $panNumber, $msme_register, $customerDetails) {
                    $uuid = (string) Str::uuid();

                    $email = $customerDetails['email'] ? $customerDetails['email'] : $request['email'];
                    $mobile_number = $customerDetails['phone'] ?? $customerDetails['mobile'] ?? $request['mobile_number'];

                    $companyData = [
                        'uuid' => $uuid,
                        'zoho_contact_id' => $customerDetails['contact_id'],
                        'company_name' => $request['company_name'],
                        'address' => $request['address'],
                        'state_id' => $request['state_id'],
                        'director_name' => $request['director_name'][0] ?? null,
                        'mobile_number' => $mobile_number,
                        'email' => $email,
                        'password' => bcrypt($request['gstn']),
                        'gstn' => strtoupper($request['gstn']),
                        'pan_number' => $panNumber,
                        'cin' => $request['cin'],
                        'cin_verify' => $request['cin'] !== null ? 1 : 0,
                        'msme_register' => $msme_register,
                        'turnover' => 0,
                        'is_auto_password' => 1,
                        'is_verify' => 1,
                        'is_active' => 1,
                    ];

                    $company = ClientCompany::where('gstn', strtoupper($request['gstn']))->first();

                    if ($company) {
                        $company->update($companyData);
                    } else {
                        $company = ClientCompany::create($companyData);
                    }
                    if (!$company) {
                        $this->info("No  record found for company ID {$company->id}, creating new one.");
                    } else {
                        $this->info("Updating existing  record for company ID {$company->id}.");
                    }
                    $teamMember = Admin::select('id')->where('is_default', 1)->first() ?? Admin::select('id')->where('role_id', 4)->first();

                    $team = new CompanyTeamMember();
                    $team->client_company_id = $company->id;
                    $team->admin_id = $teamMember->id;
                    $team->save();

                    $companyGstDetails = ClientGstDetail::where('gstn', $request['gstn'])->first();
                    if ($companyGstDetails) {
                        $companyGstDetails->client_company_id = $company->id;
                        $companyGstDetails->save();
                    }
                    if (!empty($request['director_name'][0])) {
                        ClientCompanyAuthorizedPerson::where('client_company_id', $company->id)->delete();
                        ClientCompanyAuthorizedPerson::create([
                            'client_company_id' => $company->id,
                            'name'              => $request['director_name'][0],
                            'email'             => $email,
                            'mobile'            => $mobile_number,
                        ]);
                    }
                    
                    foreach (['billing_address', 'shipping_address'] as $type) {
                        if (!empty($customerDetails[$type])) {

                            $addressType = str_replace('_address', '', $type);
                            Log::warning('customer name does not match GST business name', [
                                "{$type}" => $customerDetails[$type] ?? '',
                            ]);
                            // Try to find existing address for this company and type
                            $address = ClientCompanyAddress::where('client_company_id', $company->id)
                                ->where('type', $addressType)
                                ->first();

                            // Log for debugging
                            if (!$address) {
                                $this->info("No {$type} record found for company ID {$company->id}, creating new one.");
                            } else {

                                $this->info("Updating existing {$type} record for company ID {$company->id}.");
                            }

                            // Prepare data
                            $addressData = [
                                'address_id'  => $customerDetails[$type]['address_id'] ?? null,
                                'attention'  => $customerDetails[$type]['attention'] ?? null,
                                'address'    => $customerDetails[$type]['address'] ?? null,
                                'street2'    => $customerDetails[$type]['street2'] ?? null,
                                'city'       => $customerDetails[$type]['city'] ?? null,
                                'state'      => $customerDetails[$type]['state'] ?? null,
                                'state_code' => $customerDetails[$type]['state_code'] ?? null,
                                'zip'        => $customerDetails[$type]['zip'] ?? null,
                                'country'    => $customerDetails[$type]['country'] ?? null,
                                'phone'      => $customerDetails[$type]['phone'] ?? null,
                                'fax'        => $customerDetails[$type]['fax'] ?? null,
                            ];

                            // Update or create record
                            if ($address) {
                                $address->update($addressData);
                            } else {
                                ClientCompanyAddress::create(array_merge(
                                    ['client_company_id' => $company->id, 'type' => $addressType],
                                    $addressData
                                ));
                            }
                        }
                    }

                    Log::warning('customer name does not match GST business name', [
                        'contact_persons' => $customerDetails['contact_persons'] ?? '',
                    ]);
                });


                $totalImported++;
            }

            $hasMore = $resp['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);

        $this->info("Zoho Products sync completed. Total imported/updated: {$totalImported}");
    }
}
