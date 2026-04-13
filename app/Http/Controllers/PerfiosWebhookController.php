<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\Models\ClientCompany;
use App\Models\CreditRequest;
use App\Services\PerfiosService;
use App\Models\CreditRequestBankStatementReport;
use App\Models\CreditRequestGstScoreReport;
use App\Jobs\ProcessBSAWebhookJob;
use App\Jobs\ProcessGSTWebhookJob;
use App\Helpers\MailHelper;


class PerfiosWebhookController extends Controller
{
    protected $httpClient;
    protected $gstReason;
    protected $bsaReason;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->gstReason = 'credit request has been cancelled due to a technical issue while fetching GST reports.';
        $this->bsaReason = 'credit request has been cancelled due to a technical issue while processing your bank statement.';
    }

    /**
     * Handle GST TRRN OTP callback
     * Endpoint: /webhooks-perfios/GST_TRRN
    */
    public function handleGstCallback(Request $request)
    {
        Log::info('Perfios GST Webhook Received', [
            'payload' => $request->all(),
            'headers' => $request->headers->all(),
            'ip' => $request->ip()
            ]);
            
        try {
            $payload = $request->all();
            
            $gstReport = CreditRequestGstScoreReport::where('prfios_requestId', $payload['requestId'])->first();
                
            if(!$gstReport){
                Log::error('Perfios GST webhook error', [
                    'message' => 'not found requestId',
                    'payload' => $payload
                ]);
                
                return response()->json([
                    'status' => false,
                    'message' => 'not found requestId'
                ]);
            }
            if (($payload['statusCode'] ?? null) != 201) {
                Log::error('GST report generation failed', $payload);

                $gstReport->update([
                    'status' => 'failed',
                    'reason' => $this->gstReason
                ]);

                $credit = CreditRequest::findOrFail($gstReport->credit_request_id);
                $credit->update([
                    'status' => 'cancelled',
                    'reason' => $this->gstReason
                ]);

                try {
                    $client = ClientCompany::where('id', $credit->client_company_id)->first();

                    $subject = 'Credit Request cancelled';
                    $viewFile = 'mail-template.credit-request-cancelled';

                    $response = MailHelper::send(
                        $client->email,
                        $subject,
                        $viewFile,
                    );

                    if (!$response['status']) {
                        Log::error("credit request cancelled mail failed for {$client->email}: " . $response['message']);
                    } else {
                        Log::info("credit request cancelled mail sent to {$client->email}");
                    }

                } catch (\Throwable $e) {
                    Log::error("credit request cancelled mail error: " . $e->getMessage());
                }

                return response()->json([
                    'status' => true
                ]);
            }
           
            $gstReport->update([
                'json_payload' => json_encode(['callback_response' => $payload])
            ]);

            ProcessGSTWebhookJob::dispatch($gstReport->credit_request_id);

            return response()->json([
                'status' => true
            ]);

        } catch (\Exception $e) {

            Log::error('Perfios GST webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false
            ]);
        }
    }
    /**
     * Handle BSA (Bank Statement) callback
     * Endpoint: /webhooks-perfios/BSN
     */

    public function handleBsaCallback(Request $request)
    {
        Log::info('Perfios BSA Callback Received', [
            'payload' => $request->all(),
            'headers' => $request->headers->all(),
            'ip' => $request->ip()
        ]);

        try {

            $payload = $request->all();
            $perfiosTransactionId = $payload['perfiosTransactionId'] ?? null;
            $clientTransactionId = $payload['clientTransactionId'] ?? null;

            $report = CreditRequestBankStatementReport::where('perfiosTransactionId', $perfiosTransactionId)
                ->where('txn_id', $clientTransactionId)
                ->first();

            if(!$report){
                Log::error('Perfios BSA webhook error', [
                    'message' => 'not found perfiosTransactionId',
                    'payload' => $payload
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'not found perfiosTransactionId'
                ]);
            }
                
            if (($payload['errorCode'] ?? null) !== "E_NO_ERROR") {
                Log::error('error getting durring repoet generated', $payload);

                $report->update([
                    'status' => "failed",
                    'reason' => $this->bsaReason
                ]);

                $credit = CreditRequest::findOrFail($report->credit_request_id);
                $credit->update([
                    'status' => 'cancelled',
                    'reason' => $this->bsaReason
                ]);

                try {
                    $client = ClientCompany::where('id', $credit->client_company_id)->first();

                    $subject = 'Credit Request cancelled';
                    $viewFile = 'mail-template.credit-request-cancelled';

                    $response = MailHelper::send(
                        $client->email,
                        $subject,
                        $viewFile,
                    );

                    if (!$response['status']) {
                        Log::error("credit request cancelled mail failed for {$client->email}: " . $response['message']);
                    } else {
                        Log::info("credit request cancelled mail sent to {$client->email}");
                    }

                } catch (\Throwable $e) {
                    Log::error("credit request cancelled mail error: " . $e->getMessage());
                }


                return response()->json([
                    'status' => true
                ]);
            }
            
            $report->update([
                'payload' => json_encode(['callback_response' => $payload])
            ]);

            ProcessBSAWebhookJob::dispatch(
                $perfiosTransactionId,
                $clientTransactionId
            );

            return response()->json([
                'status' => true
            ]);
           
        } catch (\Exception $e) {

            Log::error('Perfios BSA webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false
            ]);
        }
    }

 
   
}