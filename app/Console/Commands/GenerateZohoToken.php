<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GenerateZohoToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Zoho access and refresh tokens from grant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $clientId = env('ZOHO_CLIENT_ID');
        $clientSecret = env('ZOHO_CLIENT_SECRET');
        $grantToken = env('ZOHO_GRANT_TOKEN');
        $accountsUrl = env('ZOHO_ACCOUNTS_URL');

        if (!$clientId || !$clientSecret || !$grantToken) {
            $this->error('Missing env vars: ZOHO_CLIENT_ID, ZOHO_CLIENT_SECRET, ZOHO_GRANT_TOKEN');
            return 1;
        }

        $response = Http::withOptions(['verify' => false])->asForm()->post("{$accountsUrl}/oauth/v2/token", [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $grantToken,
            'scope' => 'ZohoBooks.fullaccess.all', // Using full access scope as requested
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];
            $refreshToken = $data['refresh_token'] ?? null;
            $expiresAt = now()->addSeconds($data['expires_in']);

            DB::table('zoho_tokens')->updateOrInsert(
                ['id' => 1], // Assuming single record for simplicity
                [
                    'access_token' => $accessToken,
                    'refresh_token' => $refreshToken,
                    'expires_at' => $expiresAt,
                    'updated_at' => now(),
                ]
            );

            $this->info('Access Token: ' . $accessToken);
            $this->info('Refresh Token: ' . $refreshToken);
            $this->info('Expires At: ' . $expiresAt);
            $this->info('Tokens stored in database. Remove ZOHO_GRANT_TOKEN from .env now.');
        } else {
            $this->error('Error: ' . $response->body());
        }

        return 0;
    }
}
