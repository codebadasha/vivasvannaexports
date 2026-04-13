<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerfiosService
{
    protected $client;
    protected $baseUrl;
    protected $headers;

    public function __construct()
    {
        $this->baseUrl = env('PERFIOS_BASE_URL', 'https://hub-test.perfios.ai');
        
        $this->headers = [
            'X-Secure-Id'       => env('PERFIOS_SECURE_ID'),
            'X-Secure-Cred'     => env('PERFIOS_SECURE_CRED'),
            'X-Organization-Id' => env('PERFIOS_ORG_ID', 'Vivasvanna_R1euto'),
            'X-Report-Type'     => 'retail_org', // ← change to 'retail' if needed
            'Content-Type'      => 'application/json',
        ];

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout'  => 90,
        ]);
    }

    private function logApiCall(string $service, string $url, array $data = []): int
    {
        try {
            return DB::table('api_call_log')->insertGetId([
                'service'      => $service,
                'url'          => $url,
                'request_data' => json_encode($data),
                'status'       => 'pending',
                'request_time' => now(),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log Perfios API call', [
                'service' => $service,
                'url'     => $url,
                'error'   => $e->getMessage()
            ]);
            return 0;
        }
    }

    private function updateApiCall(int $logId, string $status, array $response = []): void
    {
        if ($logId === 0) return;

        try {
            DB::table('api_call_log')->where('id', $logId)->update([
                'status'        => $status,
                'response_data' => json_encode($response),
                'response_time' => now(),
                'updated_at'    => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update Perfios API call log', [
                'log_id' => $logId,
                'status' => $status,
                'error'  => $e->getMessage()
            ]);
        }
    }

    public function searchGstByPan(string $pan, string $consent = 'Y'): array
    {
        try {
            $payload = [
                'consent' => $consent,
                'pan'     => strtoupper(trim($pan)),
            ];

            $endpoint = '/ssp/gst/api/v2/search';
            $url = $this->baseUrl . $endpoint;
            $logId = $this->logApiCall('perfios-initiate', $url, $payload);

            $response = $this->client->post($endpoint, [
                'headers' => $this->headers,
                'json'    => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->updateApiCall($logId, 'success', $data);

            return [
                'success'   => true,
                'data'      => $data,
            ];
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            $this->updateApiCall($logId, 'failed', ['error' => $error]);
            Log::error('Perfios G failed', ['url' => $url, 'payload' => $payload, 'error' => $error]);
            return ['success' => false, 'message' => $error];
        }
    }

    public function initBankTransaction(array $payloadData)
    {
        $payload = ['payload' => array_merge($payloadData, [
            'transactionCompleteCallbackUrl' => route('perfios.webhook'),
        ])];

        $endpoint = 'ssp/insights/api/v3/transactions';
        $url = $this->baseUrl . $endpoint;
        $logId = $this->logApiCall('perfios-initiate', $url, $payload);

        try {
            $response = $this->client->post($endpoint, [
                'headers' => $this->headers,
                'json'    => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->updateApiCall($logId, 'success', $data);

            return [
                'success'              => true,
                'perfiosTransactionId' => $data['transaction']['perfiosTransactionId'] ?? null,
                'raw'                  => $data,
            ];
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            $this->updateApiCall($logId, 'failed', ['error' => $error]);
            Log::error('Perfios Initiate failed', ['url' => $url, 'payload' => $payload, 'error' => $error]);
            return ['success' => false, 'message' => $error];
        }
    }

    public function uploadBankFile(string $transactionId, string $filePath, string $originalName)
    {
        $endpoint = "ssp/insights/api/v3/transactions/{$transactionId}/files";
        $url = $this->baseUrl . $endpoint;
        $logId = $this->logApiCall('perfios-upload', $url, ['file' => $originalName]);

        try {
            $response = $this->client->post($endpoint, [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen($filePath, 'r'),
                        'filename' => $originalName,
                    ]
                ],
                'headers' => array_filter($this->headers, fn($k) => $k !== 'Content-Type', ARRAY_FILTER_USE_KEY),
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->updateApiCall($logId, 'success', $data);

            return [
                'success' => true,
                'fileId'  => $data['file']['fileId'] ?? null,
            ];
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            $this->updateApiCall($logId, 'failed', ['error' => $error]);
            Log::error('Perfios Upload failed', ['url' => $url, 'file' => $originalName, 'error' => $error]);
            $errorData = json_decode($error, true);
            return [
                'success' => false,
                'error_code' => $errorData['error']['code'] ?? null,
                'technical_message' => $errorData['error']['message'] ?? $error
            ];
        }
    }

    public function processBankStatement(string $transactionId, string $fileId, ?string $password = null)
    {
        $payload = ['payload' => ['fileId' => $fileId]];
        if ($password) $payload['payload']['password'] = $password;

        $endpoint = "ssp/insights/api/v3/transactions/{$transactionId}/bank-statements";
        $url = $this->baseUrl . $endpoint;
        $logId = $this->logApiCall('perfios-process', $url, $payload);

        try {
            $response = $this->client->post($endpoint, [
                'headers' => $this->headers,
                'json'    => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->updateApiCall($logId, 'success', $data);

            return [
                'success'   => true,
                'data'      => $data['bankStatement']['bankAccounts'][0] ?? null,
            ];
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            $this->updateApiCall($logId, 'failed', ['error' => $error]);
            Log::error('Perfios Process failed', ['url' => $url, 'payload' => $payload, 'error' => $error]);
            $errorData = json_decode($error, true);
            return [
                'success' => false,
                'error_code' => $errorData['error']['details'][0]['code'],
                'technical_message' => $errorData['error']['message'] ?? $error
            ];
        }
    }

    public function generateReport(string $transactionId)
    {
        $endpoint = "ssp/insights/api/v3/transactions/{$transactionId}/reports";
        $url = $this->baseUrl . $endpoint;
        $logId = $this->logApiCall('perfios-report', $url, []);

        try {
            $this->client->post($endpoint, [
                'headers' => $this->headers,
                'json'    => [],
            ]);

            $this->updateApiCall($logId, 'success', []);
            return ['success' => true];
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            $this->updateApiCall($logId, 'failed', ['error' => $error]);
            Log::error('Perfios Report Generation failed', ['url' => $url, 'error' => $error]);
            $errorData = json_decode($error, true);
            return [
                'success' => false,
                'error_code' => $errorData['error']['code'] ?? null,
                'technical_message' => $errorData['error']['message'] ?? $error
            ];
        }
    }

    public function initiateGstOtp(string $username, string $gstin, string $refId)
    {
        $payload = [
            'username'       => $username,
            'gstin'          => strtoupper($gstin),
            'refId'          => $refId,
            'consent'        => 'Y',
            'extendedPeriod' => false,
        ];

        $endpoint = 'ssp/gst/api/v2/gst-return-auth-advance';
        $url = $this->baseUrl . $endpoint;
        $logId = $this->logApiCall('perfios-gst-initiate', $url, $payload);

        try {
            $response = $this->client->post($endpoint, [
                'headers' => $this->headers,
                'json'    => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->updateApiCall($logId, 'success', $data);

            if (($data['statusCode'] ?? 0) === 101) {
                return [
                    'success'       => true,
                    'requestId'     => $data['requestId'],
                    'statusMessage' => $data['statusMessage'],
                ];
            }

            return ['success' => false, 'message' => $data['statusMessage'] ?? 'Unknown error'];
        } catch (\Throwable $e) {

            $error = $e->getMessage();

            if ($e instanceof RequestException && $e->hasResponse()) {
                $error = $e->getResponse()->getBody()->getContents();
            }

            $this->updateApiCall($logId, 'failed', ['error' => $error]);

            Log::error('Perfios GST Initiate failed', [
                'url' => $url,
                'payload' => $payload,
                'error' => $error
            ]);

            return [
                'success' => false,
                'message' => $error
            ];
        }
    }

    public function submitGstOtp(string $requestId, string $otp)
    {
        $payload = [
            'requestId' => $requestId,
            'otp'       => $otp,
        ];

        $endpoint = 'ssp/gst/api/v2/gst-return-auth-advance';
        $url = $this->baseUrl . $endpoint;
        $logId = $this->logApiCall('perfios-gst-submit', $url, $payload);

        try {
            $response = $this->client->post($endpoint, [
                'headers' => $this->headers,
                'json'    => $payload,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $this->updateApiCall($logId, 'success', $data);

            if (($data['statusCode'] ?? 0) === 101) {
                return [
                    'success'       => true,
                    'newRequestId'  => $data['requestId'],
                    'statusMessage' => $data['statusMessage'],
                ];
            }

            return ['success' => false, 'message' => $data['statusMessage'] ?? 'Invalid OTP'];
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            $this->updateApiCall($logId, 'failed', ['error' => $error]);
            Log::error('Perfios GST Submit failed', ['url' => $url, 'payload' => $payload, 'error' => $error]);
            return ['success' => false, 'message' => $error];
        }
    }

    public function listInstitutions(string $processingType = 'STATEMENT')
    {
        $endpoint = 'ssp/insights/api/v3/institutions';
        $url = $this->baseUrl . $endpoint . '?processingType=' . urlencode($processingType);

        $logId = $this->logApiCall('perfios-list-institutions', $url, []);

        try {
            $response = $this->client->get($endpoint, [
                'headers' => array_filter($this->headers, fn($k) => $k !== 'Content-Type', ARRAY_FILTER_USE_KEY),
                'query'   => ['processingType' => $processingType],
            ]);

            
            $data = json_decode($response->getBody()->getContents(), true);
            $this->updateApiCall($logId, 'success', $data);

            return $data;
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            $this->updateApiCall($logId, 'failed', ['error' => $error]);
            Log::error('Perfios List Institutions failed', ['url' => $url, 'error' => $error]);
            return ['success' => false, 'message' => $error];
        }
    }

    /**
     * Retrieve Reports (GET)
     * Get generated report status/links
     */
    public function retrieveReports(string $transactionId)
    {
        $endpoint = "ssp/insights/api/v3/transactions/{$transactionId}/reports";

        $logId = $this->logApiCall('perfios-retrieve-reports', $this->baseUrl . $endpoint, []);

        try {
            $response = $this->client->get($endpoint, [
                'headers' => array_filter($this->headers, fn($k) => $k !== 'Content-Type', ARRAY_FILTER_USE_KEY),
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            $this->updateApiCall($logId, 'success', $data);

            return ['success' => true, 'data' => $data];
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            $this->updateApiCall($logId, 'failed', ['error' => $error]);
            Log::error('Perfios Retrieve Reports failed', ['url' => $this->baseUrl . $endpoint, 'error' => $error]);
            return ['success' => false, 'message' => $error];
        }
    }

    public function getTransactionStatus(string $transactionId)
    {
        $endpoint = "ssp/insights/api/v3/transactions/{$transactionId}/status";
        $url = $this->baseUrl . $endpoint;

        $logId = $this->logApiCall('perfios-status', $url, []);

        try {

            $response = $this->client->get($endpoint, [
                'headers' => array_filter($this->headers, fn($k) => $k !== 'Content-Type', ARRAY_FILTER_USE_KEY),
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            $this->updateApiCall($logId, 'success', $data);

            return [
                'success' => true,
                'data' => $data
            ];

        } catch (RequestException $e) {

            $error = $e->hasResponse()
                ? $e->getResponse()->getBody()->getContents()
                : $e->getMessage();

            $this->updateApiCall($logId, 'failed', ['error' => $error]);

            Log::error('Perfios Status API failed', [
                'url' => $url,
                'error' => $error
            ]);

            return ['success' => false, 'message' => $error];
        }
    }

    public function downloadReportZip(string $transactionId)
    {
        $endpoint = "ssp/insights/api/v3/transactions/{$transactionId}/reports?types=xlsx,json";
        $url = $this->baseUrl . $endpoint;

        $logId = $this->logApiCall('perfios-download-report', $url, []);

        try {

            $response = $this->client->get($endpoint, [
                'headers' => array_filter($this->headers, fn($k) => $k !== 'Content-Type', ARRAY_FILTER_USE_KEY),
            ]);

            $zipContent = $response->getBody()->getContents();

            $this->updateApiCall($logId, 'success', ['file' => 'zip received']);

            return [
                'success' => true,
                'zip' => $zipContent
            ];

        } catch (RequestException $e) {

            $error = $e->hasResponse()
                ? $e->getResponse()->getBody()->getContents()
                : $e->getMessage();

            $this->updateApiCall($logId, 'failed', ['error' => $error]);

            Log::error('Perfios Report Download failed', [
                'url' => $url,
                'error' => $error
            ]);

            return ['success' => false, 'message' => $error];
        }
    }
}