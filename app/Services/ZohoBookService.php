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
        $response = Http::withOptions(['verify' => false])->withHeaders([
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
        $response = Http::withHeaders([
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
     * Get list of item
     */
    public function getAllCustomer(array $params = []): array
    {
        $params = [
            "contact_type" => "customer",
        ];

        return $this->get("contacts", $params);
    }


    /**
     * Get details of a specific item
     */
    public function getCustomer(string $customerId): array
    {
        return $this->get("contacts/$customerId");
    }
    
    
    
    
    
    /**
     * Get a list of invoices
     */
    public function getAllInvoices(array $params = []): array
    {

        return $this->get('invoices', $params);
    }


    

    /**
     * Create a new item
     */
    public function createItem(array $data): array
    {
        return $this->post('items', $data);
    }

    /**
     * Update an existing item
     */
    public function updateItem(string $itemId, array $data): array
    {
        return $this->put("items/{$itemId}", $data);
    }

    /**
     * Delete an item
     */
    public function deleteItem(string $itemId): array
    {
        return $this->delete("items/{$itemId}");
    }
}
