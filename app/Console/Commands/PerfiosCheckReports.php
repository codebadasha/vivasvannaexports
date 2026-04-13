<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CreditRequestBankStatementReport;
use App\Services\PerfiosService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PerfiosCheckReports extends Command
{
    protected $signature = 'perfios:check-reports';
    protected $description = 'Check Perfios report status and download reports';

    public function handle()
    {

        Log::info('Perfios Cron Started');

        try {

            $perfios = new PerfiosService();

            $reports = CreditRequestBankStatementReport::
                whereNotNull('perfiosTransactionId')
                ->limit(10)
                ->get();

            Log::info('Reports fetched', [
                'count' => $reports->count()
            ]);

            if ($reports->count() == 0) {
                Log::info('No pending reports found');
            }

            foreach ($reports as $report) {

                try {

                    Log::info('Processing transaction', [
                        'perfiosTransactionId' => $report->perfiosTransactionId,
                        'clientTransactionId' => $report->txn_id
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | STEP 1 : CALL STATUS API
                    |--------------------------------------------------------------------------
                    */

                    $status = $perfios->getTransactionStatus($report->perfiosTransactionId);

                    Log::info('Status API response', [
                        'transactionId' => $report->perfiosTransactionId,
                        'response' => $status
                    ]);

                    if (!$status['success']) {

                        Log::error('Status API failed', [
                            'transactionId' => $report->perfiosTransactionId
                        ]);

                        continue;
                    }

                    $statusData = $status['data'];

                    $transaction = $statusData['transactions']['transaction'][0] ?? [];

                    $reportAvailable = $transaction['reportAvailable'] ?? false;

                    if (!$reportAvailable) {

                        Log::info('Report not ready yet', [
                            'transactionId' => $report->perfiosTransactionId
                        ]);

                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | STEP 2 : DOWNLOAD REPORT ZIP
                    |--------------------------------------------------------------------------
                    */

                    Log::info('Downloading report ZIP', [
                        'transactionId' => $report->perfiosTransactionId
                    ]);

                    $download = $perfios->downloadReportZip($report->perfiosTransactionId);

                    if (!$download['success']) {

                        Log::error('Report download failed', [
                            'transactionId' => $report->perfiosTransactionId
                        ]);

                        continue;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | STEP 3 : SAVE ZIP FILE
                    |--------------------------------------------------------------------------
                    */

                    $folder = "bank-statements/perfios_reports";

                    if (!Storage::disk('public')->exists($folder)) {
                        Storage::disk('public')->makeDirectory($folder);
                    }

                    $fileName = $report->perfiosTransactionId . ".zip";

                    $filePath = $folder . "/" . $fileName;

                    Storage::disk('public')->put($filePath, $download['zip']);

                    Log::info('ZIP stored', [
                        'file' => $filePath
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | STEP 4 : STORE PAYLOAD JSON
                    |--------------------------------------------------------------------------
                    */

                    $payload = [
                        'statusapi' => $statusData,
                        'reportsgetapi' => 'zip_downloaded'
                    ];

                    $report->update([
                        'local_pdf_filepath' => $filePath,
                        'json_payload' => json_encode($payload)
                    ]);

                    Log::info('Database updated successfully', [
                        'transactionId' => $report->perfiosTransactionId
                    ]);

                } catch (\Exception $e) {

                    Log::error('Perfios cron error inside loop', [
                        'transactionId' => $report->perfiosTransactionId ?? null,
                        'error' => $e->getMessage()
                    ]);
                }
            }

        } catch (\Exception $e) {

            Log::error('Perfios cron fatal error', [
                'error' => $e->getMessage()
            ]);
        }

        Log::info('Perfios Cron Completed');

        $this->info('Perfios report check completed');
    }
}