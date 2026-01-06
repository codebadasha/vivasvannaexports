<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ZohoBookService;
use App\Models\SalesOrder;
use App\Models\SalesOrderInvoice;

class ZohoSyncSalesOrders extends Command
{
    protected $signature = 'zoho:sync:salesorders {--per_page=100}';
    protected $description = 'Sync Sales Orders and related invoices from Zoho Books to local database';

    public function handle(ZohoBookService $zoho)
    {
        $this->info('🚀 Starting Zoho Sales Orders sync...');
        $perPage = (int) $this->option('per_page') ?: 100;
        $page = 1;
        $total = 0;

        do {
            $this->info("📄 Fetching page {$page}...");
            $response = $zoho->getAllSalesOrders([
                'page' => $page,
                'per_page' => $perPage,
            ]);

            $salesOrders = $response['salesorders'] ?? [];
            if (empty($salesOrders)) {
                $this->info("✅ No more records found. Stopping.");
                break;
            }

            foreach ($salesOrders as $order) {
                $detailsResp = $zoho->getSalesOrder($order['salesorder_id']);
                $soDetails = $detailsResp['salesorder'] ?? [];
                // dd($soDetails);
                if (empty($soDetails)) continue;

                $soDetails['total_invoiced_amount'] = $order['total_invoiced_amount'];
                $this->info("✅ No more records found. Stopping. {$soDetails['shipment_date']}");
                SalesOrder::upsertFromZoho($soDetails);
                $total++;
                // 🧾 Sync invoices related to this Sales Order
                if (!empty($soDetails['invoices'])) {
                    foreach ($soDetails['invoices'] as $invoiceSummary) {
                        $invoiceId = $invoiceSummary['invoice_id'] ?? null;

                        if ($invoiceId) {
                            $this->info("  ↳ Syncing invoice {$invoiceSummary['invoice_number']}...");

                            $invoiceResp = $zoho->getInvoices($invoiceId);
                            $invoiceDetails = $invoiceResp['invoice'] ?? null;
                            
                            if ($invoiceDetails) {
                                SalesOrderInvoice::upsertFromZoho($invoiceDetails, $soDetails['salesorder_id']);
                            }
                        }
                    }
                }
            }

            $hasMore = $response['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);

        $this->info("🎉 Sync completed. Total imported/updated: {$total}");
    }
}
