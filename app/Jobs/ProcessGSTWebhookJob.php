<?php
namespace App\Jobs;
use Illuminate\Support\Facades\Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\CreditRequestGstScoreReport;
use App\Services\PerfiosService;

class ProcessGSTWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $requestId;

    public function __construct($requestId)
    {
        $this->requestId = $requestId;
    }

    public function handle()
    {
        $gstReport = CreditRequestGstScoreReport::where('credit_request_id', $this->requestId)->first();

        $payload = json_decode($gstReport->json_payload, true);
        $data = $payload['callback_response'] ?? [];

        $excelUrl = $data['result']['excelDownloadLink'] ?? null;
        $pdfUrl   = $data['result']['pdfDownloadLink'] ?? null;

        $excelLocalPath = null;
        $pdfLocalPath = null;

        try {

            if ($excelUrl) {

                $excelName = 'gst_excel_' . time() . '.xlsx';
                $excelLocalPath = 'gst-reports/' . $excelName;

                $response = Http::timeout(120)->get($excelUrl);

                if ($response->successful()) {
                    Storage::disk('public')->put($excelLocalPath, $response->body());
                }
                // $excelLocalPath = storage_path('app/public/' . $excelLocalPath);
            }

            if ($pdfUrl) {

                $pdfName = 'gst_pdf_' . time() . '.pdf';
                $pdfLocalPath = 'gst-reports/' . $pdfName;

                $response = Http::timeout(120)->get($pdfUrl);

                if ($response->successful()) {
                    Storage::disk('public')->put($pdfLocalPath, $response->body());
                }
                // $pdfLocalPath = storage_path('app/public/' . $pdfLocalPath);
            }

        } catch (\Exception $e) {

            Log::error('GST Job download failed', [
                'requestId' => $this->requestId,
                'error' => $e->getMessage()
            ]);
        }

        $gstReport->update([
            'status' => 'generated',
            'perfios_pdffilelink' => $pdfUrl,
            'perfios_excexlfilelink' => $excelUrl,
            'local_excexlfilepath' => $pdfLocalPath,
            'local_pdffilepath' => $excelLocalPath
        ]);
        
    }
}