<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ZohoBookService;
use App\Models\SalesOrder;
use App\Models\SalesOrderInvoice;
use Illuminate\Support\Facades\Log;
use App\Services\ZohoWebhookHandler;

class ZohoSyncSalesOrdersinvoice extends Command
{
    protected $signature = 'zoho:sync:invoices {--per_page=100}';
    protected $description = 'Sync invoices from Zoho Books to local database';

    public function handle(ZohoBookService $zoho, ZohoWebhookHandler $handler)
    {
        $this->info('🚀 Starting Zoho Sales Orders sync...');
        $perPage = (int) $this->option('per_page') ?: 100;
        $page = 1;
        $totalinvoice = 0;
        $totalgetinvoice = 0;
        $status = ["void","draft","pending_approval"];

        do {
            $this->info("📄 Fetching page {$page}...");
            $response = $zoho->getAllInvoices([
                'page' => $page,
                'per_page' => $perPage,
                'sort_order' => "A"
            ]);

            $invoices = $response['invoices'] ?? [];
            if (empty($invoices)) {
                $this->info("✅ No more records found. Stopping.");
                break;
            }

            foreach ($invoices as $invoice) {
                $totalgetinvoice++;
                if (in_array($invoice['status'], $status)) {
                    Log::info("Sync invoice Skipping ID :- {$invoice['invoice_id']} Number:- {$invoice['invoice_number']} Order number:- {$invoice['reference_number']} invalid status {$invoice['status']}");
                    continue;
                }
                
                $this->info("  ↳ Syncing invoice {$invoice['invoice_number']}...");

                $invoiceId = $invoice['invoice_id'] ?? null;

                if($invoiceId){
                    $totalinvoice++;
                    $handler->process('invoices', 'upsert', $invoiceId, true);
                }

            }
            $hasMore = $response['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);
        $this->info("🎉 Sync completed. Total imported/updated:  totalgetinvoice :- {$totalgetinvoice} totalinvoice :- {$totalinvoice}....");
    }
}
