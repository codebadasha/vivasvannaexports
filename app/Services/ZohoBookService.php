<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ZohoBookService
{
    private $apiUrl;
    private $orgId;
    private $accountsUrl;

    public function __construct()
    {
        $this->apiUrl = env('ZOHO_API_URL');
        $this->orgId = env('ZOHO_ORG_ID');
        $this->accountsUrl = env('ZOHO_ACCOUNTS_URL');
        // Set IST timezone for consistency with your location
        date_default_timezone_set('Asia/Kolkata');
    }

    /**
     * Get fresh access token (from database or refresh)
     */
    public function getAccessToken()
    {
        $token = DB::table('zoho_tokens')->first();

        Log::info('Zoho API Refresh Token', ['expires_at' => $token->expires_at]);

        if (!$token || now()->greaterThan($token->expires_at)) {
            $this->refreshToken();
            $token = DB::table('zoho_tokens')->first();
            if (!$token) {
                throw new \Exception('Token refresh failed to update database.');
            }
        }
        return $token->access_token;
    }

    /**
     * Refresh access token using refresh token
     */
    private function refreshToken()
    {
        $token = DB::table('zoho_tokens')->first();
        if (!$token || !$token->refresh_token) {
            throw new \Exception('No refresh token available. Re-run zoho:generate-token.');
        }

        $clientId = env('ZOHO_CLIENT_ID');
        $clientSecret = env('ZOHO_CLIENT_SECRET');

        $response = Http::withOptions(['verify' => false])->asForm()->post("{$this->accountsUrl}/oauth/v2/token", [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $token->refresh_token,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $expiresAt = now()->addSeconds($data['expires_in']);
            Log::info('Zoho token refreshed', [
                'access_token' => $data['access_token'],
                'expires_at' => $expiresAt,
                'time' => now(),
            ]);

            DB::table('zoho_tokens')
                ->where('id', $token->id)
                ->update([
                    'access_token' => $data['access_token'],
                    'refresh_token' => $data['refresh_token'] ?? $token->refresh_token,
                    'expires_at' => $expiresAt,
                    'updated_at' => now(),
                ]);
        } else {
            Log::error('Token refresh failed', ['response' => $response->body()]);
            throw new \Exception('Token refresh failed: ' . $response->body());
        }
    }

    /**
     * Make a GET request to Zoho API
     */
    public function get($endpoint, $params = [])
    {

        $url = "{$this->apiUrl}/{$endpoint}?organization_id={$this->orgId}";
        if (!empty($params)) {
            $url .= '&' . http_build_query($params);
        }

        Log::info('Zoho API Request', ['url' => $url]); // Debug the request URL

        $token = $this->getAccessToken();
        $response = Http::withOptions([
            'verify' => false,
            'timeout' => 30, // ⏰ increase timeout to 30 seconds
        ])->retry(3, 2000)->withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->get($url);

        if (!$response->successful()) {
            Log::error('Zoho GET API ' . $endpoint . ' error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \Exception('API request failed: ' . $response->status() . ' - ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Make a POST request to Zoho API
     */
    public function post($endpoint, $data = [])
    {
        $url = "{$this->apiUrl}/{$endpoint}?organization_id={$this->orgId}";
        $token = $this->getAccessToken();
        $response = Http::withOptions([
            'verify' => false,
            'timeout' => 30, // ⏰ increase timeout to 30 seconds
        ])->retry(3, 2000)->withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->post($url, $data);

        if (!$response->successful()) {
            Log::error('Zoho POST API ' . $endpoint . ' error', ['body' => $response->body()]);
            throw new \Exception('API request failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Make a PUT request to Zoho API
     */
    public function put($endpoint, $data = [])
    {

        $url = "{$this->apiUrl}/{$endpoint}?organization_id={$this->orgId}";
        $token = $this->getAccessToken();
        $response = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->put($url, $data);

        if (!$response->successful()) {
            Log::error('Zoho PUT API ' . $endpoint . ' error', ['body' => $response->body()]);
            throw new \Exception('API request failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Make a DELETE request to Zoho API
     */
    public function delete($endpoint, $params = [])
    {
        $url = "{$this->apiUrl}/{$endpoint}?organization_id={$this->orgId}";
        if (!empty($params)) {
            $url .= '&' . http_build_query($params);
        }

        $token = $this->getAccessToken();
        $response = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->delete($url);

        if (!$response->successful()) {
            Log::error('Zoho DELETE API ' . $endpoint . ' error', ['body' => $response->body()]);
            throw new \Exception('API request failed: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Get a list of Tax
     */
    public function getAllTaxes(array $params = []): array
    {
        return $this->get('settings/taxes', $params);
    }

    /**
     * Get details of a specific Tax
     */
    public function getTax(string $taxesId): array
    {
        return $this->get("settings/taxes/$taxesId");
    }

    /**
     * Get details of a specific Tax
     */
    public function getTaxGroup(string $taxesId): array
    {
        return $this->get("settings/taxgroups/$taxesId");
    }


    /**
     * Get list of item
     */
    public function getAllItem(array $params = []): array
    {
        return $this->get("items", $params);
    }


    /**
     * Get details of a specific item
     */
    public function getItem(string $itemId): array
    {
        return $this->get("items/$itemId");
    }

    /**
     * Get list of Customer
     */
    public function getAllCustomer(array $params = []): array
    {
        $params['contact_type'] = 'customer';
        return $this->get("contacts", $params);
    }


    /**
     * Get details of a specific Customer
     */
    public function getCustomer(string $customerId): array
    {
        return $this->get("contacts/$customerId");
    }

    /**
     * Get list of Vendor
     */
    public function getAllVendor(array $params = []): array
    {
        $params['contact_type'] = 'vendor';
        return $this->get("contacts", $params);
    }


    /**
     * Get details of a specific Vendor
     */
    public function getVendor(string $vendorId): array
    {
        return $this->get("contacts/$vendorId");
    }

    /**
     * Get list of Vendor
     */
    public function getAllSalesOrders(array $params = []): array
    {
        // $params["filter_by"] = "Status.Invoiced";
        return $this->get("salesorders", $params);
    }


    /**
     * Get details of a specific Vendor
     */
    public function getSalesOrder(string $salesorderId, array $params = [])
    {
        // $params['accept'] = 'pdf';
        return $this->get("salesorders/$salesorderId", $params);
    }

    /**
     * Get a list of invoices
     */
    public function getAllInvoices(array $params = []): array
    {
        return $this->get('invoices', $params);
    }

    /**
     * Get details of a specific Vendor
     */
    public function getInvoices(string $salesorderId, array $params = [])
    {
        return $this->get("invoices/$salesorderId", $params);
    }


    /**
     * Get list of Vendor
     */
    public function getAllPurchaseorders(array $params = []): array
    {
        $params["Status"] = "billed";
        return $this->get("purchaseorders", $params);
    }


    /**
     * Get details of a specific Vendor
     */
    public function getPurchaseorder(string $purchaseorderId, array $params = [])
    {
        return $this->get("purchaseorders/$purchaseorderId", $params);
    }

    /**
     * Get a list of invoices
     */
    public function getAllBills(array $params = []): array
    {
        return $this->get('bills', $params);
    }

    /**
     * Get details of a specific Vendor
     */
    public function getbill(string $billId, array $params = [])
    {
        return $this->get("bills/$billId", $params);
    }


    public function getSalesOrderHtml(string $salesorderId, array $params = []): string
    {
        $params['accept'] = 'html';
        $url = "salesorders/$salesorderId";

        Log::info('Fetching Zoho Sales Order in HTML', ['salesorder_id' => $salesorderId, 'params' => $params]);

        $token = $this->getAccessToken();
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->get("{$this->apiUrl}/{$url}?organization_id={$this->orgId}&" . http_build_query($params));

        if (!$response->successful()) {
            Log::error('Zoho Sales Order HTML fetch failed', [
                'salesorder_id' => $salesorderId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to fetch Sales Order HTML: ' . $response->status() . ' - ' . $response->body());
        }

        return $response->body();
    }

    public function getSalesOrderPdf(string $salesorderId): string
    {
        $params['accept'] = 'pdf';
        $url = "salesorders/$salesorderId";

        Log::info('Fetching Zoho Sales Order PDF', ['salesorder_id' => $salesorderId]);

        $token = $this->getAccessToken();

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->get("{$this->apiUrl}/{$url}?organization_id={$this->orgId}&" . http_build_query($params));

        if (!$response->successful()) {
            Log::error('Zoho Sales Order PDF fetch failed', [
                'salesorder_id' => $salesorderId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to fetch Sales Order PDF: ' . $response->status() . ' - ' . $response->body());
        }

        return $response->body(); // PDF binary
    }

    public function getInvoiceHtml(string $invoiceId, array $params = []): string
    {
        $params['accept'] = 'html';
        $url = "invoices/$invoiceId";

        Log::info('Fetching Zoho Sales Order in HTML', ['invoice_id' => $invoiceId, 'params' => $params]);

        $token = $this->getAccessToken();
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->get("{$this->apiUrl}/{$url}?organization_id={$this->orgId}&" . http_build_query($params));

        if (!$response->successful()) {
            Log::error('Zoho Sales Order HTML fetch failed', [
                'invoice_id' => $invoiceId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to fetch Sales Order HTML: ' . $response->status() . ' - ' . $response->body());
        }

        return $response->body();
    }

    public function getInvoicePdf(string $invoiceId): string
    {
        $params['accept'] = 'pdf';
        $url = "invoices/$invoiceId";

        Log::info('Fetching Zoho Invoice PDF', ['invoice_id' => $invoiceId]);

        $token = $this->getAccessToken();

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->get("{$this->apiUrl}/{$url}?organization_id={$this->orgId}&" . http_build_query($params));

        if (!$response->successful()) {
            Log::error('Zoho Invoice PDF fetch failed', [
                'invoice_id' => $invoiceId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to fetch Invoice PDF: ' . $response->status() . ' - ' . $response->body());
        }

        return $response->body(); // PDF binary
    }

    public function getPurchaseOrderHtml(string $purchaseorderId, array $params = []): string
    {
        $params['accept'] = 'html';
        $url = "purchaseorders/$purchaseorderId";

        Log::info('Fetching Zoho purchase Order in HTML', ['salesorder_id' => $purchaseorderId, 'params' => $params]);

        $token = $this->getAccessToken();
        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->get("{$this->apiUrl}/{$url}?organization_id={$this->orgId}&" . http_build_query($params));

        if (!$response->successful()) {
            Log::error('Zoho purchaseorders Order HTML fetch failed', [
                'salesorder_id' => $purchaseorderId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to fetch Sales Order HTML: ' . $response->status() . ' - ' . $response->body());
        }

        return $response->body();
    }

    public function getPurchaseOrderPdf(string $purchaseorderId): string
    {
        $params['accept'] = 'pdf';
        $url = "purchaseorders/$purchaseorderId";

        Log::info('Fetching Zoho Sales Order PDF', ['purchaseorder_id' => $purchaseorderId]);

        $token = $this->getAccessToken();

        $response = Http::withOptions(['verify' => false])->withHeaders([
            'Authorization' => "Zoho-oauthtoken {$token}",
        ])->get("{$this->apiUrl}/{$url}?organization_id={$this->orgId}&" . http_build_query($params));

        if (!$response->successful()) {
            Log::error('Zoho Sales Order PDF fetch failed', [
                'purchaseorder_id' => $purchaseorderId,
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception('Failed to fetch Purchase Order PDF: ' . $response->status() . ' - ' . $response->body());
        }

        return $response->body(); // PDF binary
    }

    public function createCustomer(array $payload): array
    {
        return $this->post("contacts", $payload);
    }
}
