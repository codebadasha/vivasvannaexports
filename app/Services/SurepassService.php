<?php

namespace App\Services;

use App\Helpers\DefaultResponse;
use App\Models\ClientCompany;
use App\Models\ClientGstDetail;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurepassService
{
    protected $api;
    protected $baseUrl;
    protected $apiKey;
    protected $clientId;
    protected $defaultHeader;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
        // $this->baseUrl = config('services.surepass.base_url', 'https://kyc-api.surepass.app/api/v1/');
        // $this->apiKey = config('services.surepass.api_key', ''); // Ensure this is set in .env
        // $this->clientId = config('services.surepass.client_id', '');
        $this->apiKey  = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmcmVzaCI6ZmFsc2UsImlhdCI6MTcwOTEwNTY1OSwianRpIjoiNGQxMmRkZWItYjcyYy00MjAxLWE0MjYtODAwYzJkZDMyZTA5IiwidHlwZSI6ImFjY2VzcyIsImlkZW50aXR5IjoiZGV2LnZpdmFzdmFubmFAc3VyZXBhc3MuaW8iLCJuYmYiOjE3MDkxMDU2NTksImV4cCI6MjMzOTgyNTY1OSwidXNlcl9jbGFpbXMiOnsic2NvcGVzIjpbInVzZXIiXX19.LHTmCsTllwkLUOZDjdR8gevUx0cLfE03VznOoFWMpEk";
        $this->clientId = "luv.jain@vivasvannaexports.com";
        $this->baseUrl = "https://kyc-api.surepass.app/api/v1/";

        if (empty($this->apiKey) || empty($this->clientId)) {
            Log::critical('Surepass API credentials missing', ['base_url' => $this->baseUrl]);
            throw new \Exception('Surepass API credentials are not configured');
        }

        $this->defaultHeader = [
            'Authorization' => "Bearer {$this->apiKey}",
            'x-client-id' => $this->clientId,
            'x-content-type' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    private function logApiCall(string $service, string $url, array $data): int
    {
        try {
            return DB::table('api_call_log')->insertGetId([
                'service' => $service,
                'url' => $url,
                'request_data' => json_encode($data),
                'status' => 'pending',
                'request_time' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log API call', [
                'service' => $service,
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    private function updateApiCall(int $logId, string $status, array $response)
    {
        try {
            DB::table('api_call_log')->where('id', $logId)->update([
                'status' => $status,
                'response_data' => json_encode($response),
                'response_time' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update API call log', [
                'log_id' => $logId,
                'status' => $status,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function callApi(string $endpoint, array $data, string $serviceName): array
    {
        $url = $this->baseUrl . $endpoint;
        $serviceName = "surepass-" . $serviceName;
        $logId = $this->logApiCall($serviceName, $url, $data);

        $headers = array_merge($this->defaultHeader, [
            'x-content-length' => strlen(json_encode($data))
        ]);

        try {
            $result = $this->api->post($url, $data, $headers);

            $this->updateApiCall($logId, $result['success'] ? 'success' : 'failed', $result);

            if (
                !isset($result['status_code']) ||
                $result['status_code'] !== 200 ||
                !$result['success'] ||
                empty($result['data'])
            ) {
                Log::error("API call failed for {$serviceName}", [
                    'url' => $url,
                    'response' => $result
                ]);
                return DefaultResponse::error($result['message'] ?? "API call failed for {$serviceName}");
            }

            return DefaultResponse::success($result['data'], $result['message'] ?? 'Success');
        } catch (\Exception $e) {
            $this->updateApiCall($logId, 'failed', ['error' => $e->getMessage()]);
            Log::error("Exception during API call for {$serviceName}", [
                'url' => $url,
                'error' => $e->getMessage()
            ]);
            return DefaultResponse::error('API request failed: ' . $e->getMessage());
        }
    }

    public function verificationProcess($gstNumber)
    {
        try {

            $existingCompany = ClientCompany::where('gstn', $gstNumber)->first();
            $companygGstDetails = ClientGstDetail::where('gstn', $gstNumber)->first();

            if ($existingCompany && $companygGstDetails) {
                Log::warning('GSTIN already registered with verified details', ['gstin' => $gstNumber]);
                return response()->json(DefaultResponse::error(
                    'GSTIN is already registered'
                ), 400);
            }

            // Step 1: Validate GSTIN

            $gstCheck = $this->gstVerification($gstNumber);
            if (!$gstCheck['status']) {
                Log::error('GSTIN validation failed', [
                    'gstin' => $gstNumber,
                    'error' => $gstCheck['message'] ?? 'Unknown error'
                ]);
                return response()->json(DefaultResponse::error(
                    $gstCheck['message'] ?? 'GSTIN validation failed'
                ), 400);
            }

            $gstData = $gstCheck['data'];
            if (($gstData['gstin_status'] ?? '') !== 'Active') {
                Log::warning('GSTIN is not active', ['gstin' => $gstNumber]);
                return response()->json(DefaultResponse::error('GSTIN is not active'), 400);
            }

            $panNumber = $gstData['pan_number'] ?? null;

            if (!$panNumber) {
                Log::error('PAN number missing in GST data', ['gstin' => $gstNumber]);
                return response()->json(DefaultResponse::error("PAN number not found For $gstData "), 400);
            }

            // Step 2: Validate PAN
            $panCheck = $this->panVerification($panNumber);
            if (!$panCheck['status']) {
                Log::error('PAN validation failed', [
                    'pan' => $panNumber,
                    'error' => $panCheck['message'] ?? 'Unknown error'
                ]);
                return response()->json(DefaultResponse::error(
                    $panCheck['message'] ?? 'PAN validation failed'
                ), 400);
            }
            $business_name = $gstData['business_name'];
            $panData = $panCheck['data'];
            $panData['promoters'] = $gstData['promoters'];
            
            if (($panData['full_name'] ?? '') !== ($gstData['business_name'] ?? '') && in_array($panData['full_name'], $gstData['promoters'])) {
                Log::warning('PAN name does not match GST business name', [
                    'pan_name' => $panData['full_name'] ?? '',
                    'gst_name' => $gstData['business_name'] ?? ''
                ]);
                return response()->json(DefaultResponse::error(
                    'PAN name does not match GST business name'
                ), 400);
            }

            // // Step 4: Validate CIN
            $cinCheck = $this->cinVerification($business_name);
            $cinNumber = null;

            if ($cinCheck['status']) {
                $cinData = $cinCheck['data'] ?? [];

                if (!empty($cinData['company_list'])) {
                    $cinNumber = $this->findCompany($cinData['company_list'], $business_name);
                }
            }

            $address = $gstData['contact_details']['principal']['address'] ?? '';
            $addressComponents = array_map('trim', explode(',', $address));
            $stateName = $addressComponents[count($addressComponents) - 2] ?? null;
            $state = State::select('id')->where('name', $stateName)->first();
            $stateId = $state ? $state->id : 0;

            $companyData = [
                'director_name' => $gstData['promoters'],
                'pan_number' => $panNumber,
                'company_name' => $business_name,
                'mobile_number' => $gstData['contact_details']['principal']['mobile'],
                'email' => $gstData['contact_details']['principal']['email'],
                'address' => $address,
                'state_id' => $stateId,
                'gstn' => $gstNumber,
                'cin' => $cinNumber,
                'msme_register' => 0,
            ];

            $promoters = !empty($gstData['promoters']) ? json_encode($gstData['promoters']) : null;

            $gstDetailsData = [
                'gstn' => $gstNumber,
                'pan' => $panNumber,
                'cin' => $cinNumber,
                'business_name' => $business_name ?? null,
                'legal_name' => $gstData['legal_name'] ?? null,
                'constitution_of_business' => $gstData['constitution_of_business'] ?? null,
                'taxpayer_type' => $gstData['taxpayer_type'] ?? null,
                'gstin_status' => $gstData['gstin_status'] ?? null,
                'center_jurisdiction' => $gstData['center_jurisdiction'] ?? null,
                'state_jurisdiction' => $gstData['state_jurisdiction'] ?? null,
                'date_of_registration' => !empty($gstData['date_of_registration'])
                    ? date('Y-m-d', strtotime($gstData['date_of_registration']))
                    : null,
                'nature_of_business' => $gstData['nature_of_business'] ?? null,
                'nature_bus_activities' => !empty($gstData['nature_bus_activities'])
                    ? json_encode($gstData['nature_bus_activities'])
                    : null,
                'promoters' => $promoters,
                'annual_turnover' => $gstData['annual_turnover'] ?? null,
                'annual_turnover_fy' => $gstData['annual_turnover_fy'] ?? null,
                'aadhaar_validation' => $gstData['aadhaar_validation'] ?? null,
                'aadhaar_validation_date' => !empty($gstData['aadhaar_validation_date'])
                    ? date('Y-m-d', strtotime($gstData['aadhaar_validation_date']))
                    : null,
                'einvoice_status' => $gstData['einvoice_status'] ?? false,
            ];

            try {
                ClientGstDetail::updateOrCreate(
                    ['gstn' => $gstDetailsData['gstn']],
                    $gstDetailsData
                );

                return response()->json(
                    DefaultResponse::success($companyData, 'GSTIN verification successfully.'),
                    200
                );
            } catch (\Exception $e) {
                Log::error('Exception error', [
                    'gstin' => $gstNumber,
                    'error' => $e->getMessage()
                ]);
                return response()->json(
                    DefaultResponse::error('Something went wrong, GSTIN verification failed: ' . 'GSTIN verification failed.'),
                    500
                );
            }

            // $insertData = $companyData;
            // $insertData['director_name'] = $gstData['promoters'][0];
            // $insertData['company_promoters'] = $promoters;
            // $insertData['company_details_verify'] = 1;

            // Step 3: Update or create records in a transaction
            // try {
            //     DB::transaction(function () use ($existingCompany, $insertData, $gstDetailsData) {
            //         if ($existingCompany) {
            //             // Update existing company
            //             $existingCompany->update($insertData);

            //             // Update or create client_gst_details
            //             ClientGstDetail::updateOrCreate(
            //                 ['client_company_id' => $existingCompany->id],
            //                 array_merge($gstDetailsData, ['client_company_id' => $existingCompany->id])
            //             );
            //         } else {
            //             // Create new company
            //             $uuid = (string) Str::uuid();
            //             $insertData['uuid'] = $uuid;
            //             $company = ClientCompany::create($insertData);

            //             // Create client_gst_details
            //             $gstDetailsData['client_company_id'] = $company->id;
            //             ClientGstDetail::create($gstDetailsData);
            //         }
            //     });

            //     return response()->json(DefaultResponse::success($companyData, 'GSTIN verification successfully'));
            // } catch (\Exception $e) {
            //     Log::error('GSTIN ins failed', [
            //         'gstin' => $request->gstin,
            //         'error' => $e->getMessage()
            //     ]);
            //     return response()->json(DefaultResponse::error('Something went wrong, GSTIN verification failed 1'), 500);
            // }

        } catch (\Exception $e) {
            Log::error('Exception error', [
                'gstin' => $gstNumber,
                'error' => $e->getMessage()
            ]);
            return response()->json(DefaultResponse::error('Something wrong, GSTIN verification failed'), 500);
        }
    }

    public function gstVerification(string $gstNumber): array
    {
        return $this->callApi('corporate/gstin-advanced', ['id_number' => $gstNumber], 'ValidateGSTIN');
    }

    public function cinVerification(string $companyName): array
    {
        return $this->callApi('corporate/name-to-cin-list', ['company_name_search' => $companyName], 'ValidateCIN');
    }

    public function msmeVerification(string $panNumber): array
    {
        return $this->callApi('corporate/pan-udyam-check', ['pan_number' => $panNumber, "enrich" => "true"], 'ValidateCIN');
    }

    public function panVerification(string $panNumber): array
    {
        return $this->callApi('pan/pan', ['id_number' => $panNumber], 'ValidatePAN');
    }

    public function getGstByPan(string $panNumber): array
    {
        return $this->callApi('corporate/gstin-by-pan', ['id_number' => $panNumber], 'GetGSTByPAN');
    }

    private function normalizeCompanyName(string $name): string
    {
        $name = strtoupper($name);
        $name = str_replace(['.', ','], '', $name);
        $removeWords = [
            "PRIVATE LIMITED",
            "PVT LTD",
            "LIMITED LIABILITY PARTNERSHIP",
            "LIMITED",
            "LTD",
            "LLP"
        ];
        $name = str_replace($removeWords, '', $name);
        $name = preg_replace('/\s+/', ' ', $name);
        return trim($name);
    }

    /**
     * Find company in list by normalized name
     */
    protected function findCompany(array $company_list, string $searchName): ?string
    {
        $normalizedSearch = $this->normalizeCompanyName($searchName);

        foreach ($company_list as $company) {
            $normalizedCompany = $this->normalizeCompanyName($company['company_name']);
            if ($normalizedCompany === $normalizedSearch) {
                return $company['cin_number'];
            }
        }

        return null;
    }
}
