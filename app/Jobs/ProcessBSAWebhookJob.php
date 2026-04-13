<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\CreditRequestBankStatementReport;
use App\Services\PerfiosService;

class ProcessBSAWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $perfiosTransactionId;
    public $clientTransactionId;

    /**
     * Create a new job instance.
     */
    public function __construct($perfiosTransactionId, $clientTransactionId)
    {
        $this->perfiosTransactionId = $perfiosTransactionId;
        $this->clientTransactionId = $clientTransactionId;
    }

    /**
     * Execute the job.
     */
    public function handle(PerfiosService $perfios): void
    {
        Log::info('BAS Report geting start');
        try{
            $report = CreditRequestBankStatementReport::where('perfiosTransactionId', $this->perfiosTransactionId)
                    ->where('txn_id', $this->clientTransactionId)
                    ->first();

            if (!$report) {
                Log::error('Report not found for webhook job', [
                    'perfiosTransactionId' => $this->perfiosTransactionId,
                    'clientTransactionId' => $this->clientTransactionId
                ]);
                return;
            }

            $status = $perfios->getTransactionStatus($report->perfiosTransactionId);

            Log::info('Status API response', [
                'transactionId' => $report->perfiosTransactionId,
                'response' => $status
            ]);

            if (!$status['success']) {
                Log::error('Status API failed', [
                    'transactionId' => $report->perfiosTransactionId
                ]);
                return;
            }

            $statusData = $status['data'];
            $transaction = $statusData['transactions']['transaction'][0] ?? [];
            $reportAvailable = $transaction['reportAvailable'] ?? false;
        
            if (!$reportAvailable) {
                Log::info('Report not ready yet', [
                    'transactionId' => $report->perfiosTransactionId
                ]);
                return;
            }

            Log::info('Downloading report ZIP', [
                'transactionId' => $report->perfiosTransactionId
            ]);

            $download = $perfios->downloadReportZip($report->perfiosTransactionId);

            if (!$download['success']) {
                Log::error('Report download failed', [
                    'transactionId' => $report->perfiosTransactionId
                ]);
                return;
            }

            $folder = "bsa-reports";

            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            $fileName = $report->perfiosTransactionId . ".zip";

            $filePath = $folder . "/" . $fileName;

            Storage::disk('public')->put($filePath, $download['zip']);

            // $fullPath = storage_path('app/public/' . $filePath);
            Log::info('ZIP stored', [
                'file' => $filePath
            ]);

            $payload = json_decode($report->payload, true) ?? [];

            $report->update([
                'local_pdf_filepath' => $filePath,
                'payload' => json_encode($payload),
                'status' => "generated"
            ]);

            Log::info('Database updated successfully', [
                'transactionId' => $report->perfiosTransactionId
            ]);
            return;
        } catch (\Exception $e) {

            Log::error('Perfios cron error inside loop', [
                'transactionId' => $report->perfiosTransactionId ?? null,
                'error' => $e->getMessage()
            ]);
            return;
        }
        Log::info('Perfios Cron Completed');
    }
}
