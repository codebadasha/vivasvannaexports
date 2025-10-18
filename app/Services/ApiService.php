<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    public function request(string $method, string $url, array $data = [], array $headers = [])
    {
        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders($headers)
                ->send($method, $url, ['json' => $data]);

            // ✅ Directly return API response (decoded JSON if possible)
            return $response->json() ?? $response->body();

        } catch (\Exception $e) {
            Log::error("API {$method} Exception", [
                'full_url' => $url,
                'data'     => $data,
                'message'  => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            // ✅ Return error in same format
            return [
                'success' => false,
                'message' => 'API request failed',
                'error'   => $e->getMessage(),
            ];
        }
    }

    public function get($url, $headers = [])
    {
        return $this->request('GET', $url, [], $headers);
    }

    public function post($url, $data = [], $headers = [])
    {
        return $this->request('POST', $url, $data, $headers);
    }

    public function put($url, $data = [], $headers = [])
    {
        return $this->request('PUT', $url, $data, $headers);
    }

    public function delete($url, $data = [], $headers = [])
    {
        return $this->request('DELETE', $url, $data, $headers);
    }
}
