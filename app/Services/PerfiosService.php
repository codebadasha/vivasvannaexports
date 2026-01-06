<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PerfiosService
{
    private $api;
    private $base_url;
    private $authHeaders;

    public function __construct(ApiService $api)
    {
        $this->api = $api;

        $this->base_url = rtrim(env('PERFIOS_SSP_BASE_URL'), '/');

        $this->authHeaders = [
            'x-secure-id'      => env('PERFIOS_SSP_SECURE_ID'),
            'x-secure-cred'    => env('PERFIOS_SSP_SECURE_CRED'),
            'x-organization-ID'=> env('PERFIOS_SSP_ORG_ID'),
            'Content-Type'     => 'application/json',
        ];
    }

    /** Allow overriding auth headers dynamically */
    public function setAuth(array $extra): self
    {
        $this->authHeaders = array_merge($this->authHeaders, $extra);
        return $this;
    }

    /* ----------------------------------------------------------
     * 1) GST Search by PAN
     * ---------------------------------------------------------- */
    public function searchGstByPan(string $pan, string $consent = 'Y'): array
    {
        $url = $this->base_url . '/ssp/gst/api/v2/search';

        $data = [
            'consent' => $consent,
            'pan'     => strtoupper(trim($pan)),
        ];

        $response = $this->api->post($url, $data, $this->authHeaders);

        if (isset($response['success']) && $response['success'] === false) {
            return $response;
        }

        return [
            'success' => true,
            'data'    => $response
        ];
    }

    /* ----------------------------------------------------------
     * 2) GST TRRN OTP Request
     * ---------------------------------------------------------- */
    public function requestTrrnOtpAdvance(
        string $username,
        string $gstin,
        string $refId,
        string $consent = 'Y',
        bool $extended = false,
        bool $consolidate = false
    ): array {

        $url = $this->base_url . '/ssp/gst/api/v2/gst-return-auth-advance';

        $data = [
            'username'      => trim($username),
            'gstin'         => strtoupper(trim($gstin)),
            'refId'         => $refId,
            'consent'       => $consent,
            'extendedPeriod'=> $extended,
            'consolidate'   => $consolidate,
        ];

        $response = $this->api->post($url, $data, $this->authHeaders);

        if (isset($response['success']) && $response['success'] === false) {
            return $response;
        }

        return [
            'success' => true,
            'data'    => $response,
            'trrn'    => $response['trrn'] ?? null,
        ];
    }

    /* ----------------------------------------------------------
     * 3) GST TRRN OTP Submit
     * ---------------------------------------------------------- */
    public function submitTrrnOtp(
        string $gstin,
        string $trrn,
        string $otp,
        string $refId
    ): array {

        // Update URL if Perfios provides different URL
        $url = $this->base_url . '/ssp/gst/api/v2/gst-return-auth-otp-submit';

        $data = [
            'gstin' => strtoupper($gstin),
            'trrn'  => $trrn,
            'otp'   => $otp,
            'refId' => $refId,
        ];

        $response = $this->api->post($url, $data, $this->authHeaders);

        if (isset($response['success']) && !$response['success']) {
            return $response;
        }

        return [
            'success' => true,
            'data'    => $response
        ];
    }


    /* ----------------------------------------------------------
     * 4) BSA Statement Upload (Bank Statement Upload)
     * ---------------------------------------------------------- */
    public function uploadBsaStatement(array $payload): array
    {
        $url = $this->base_url . '/ssp/bsa/api/v3/upload';

        $response = $this->api->post($url, $payload, $this->authHeaders);

        if (isset($response['success']) && !$response['success']) {
            return $response;
        }

        return [
            'success' => true,
            'data'    => $response
        ];
    }
}
