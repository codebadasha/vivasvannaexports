<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ZohoBookService;
use App\Models\SalesOrder;
use App\Models\SalesOrderInvoice;
use Illuminate\Support\Facades\Log;

class ZohoSyncSalesOrders extends Command
{
    protected $signature = 'zoho:sync:salesorders {--per_page=100}';
    protected $description = 'Sync Sales Orders and related invoices from Zoho Books to local database';

    public function handle(ZohoBookService $zoho)
    {
        $this->info('🚀 Starting Zoho Sales Orders sync...');
        $perPage = (int) $this->option('per_page') ?: 100;
        $page = 1;
        $totalSo = 0;
        $order_status = ["void","rejected","draft","pending_approval","viewed"];
        $st=[];
        $ost=[];
        $both=[];
        do {
            $this->info("📄 Fetching page {$page}...");
            $response = $zoho->getAllSalesOrders([
                'page' => $page,
                'per_page' => $perPage,
                'sort_order' => "A"
            ]);

            $salesOrders = $response['salesorders'] ?? [];
            if (empty($salesOrders)) {
                $this->info("✅ No more records found. Stopping.");
                break;
            }

            foreach ($salesOrders as $order) {

                if (in_array($order['order_status'], $order_status)) {
                    Log::info("Sync Salesorder Skipping ID:- {$order['salesorder_id']} Number:- {$order['salesorder_number']} invalid status {$order['order_status']}");
                    continue;
                }
                
                $detailsResp = $zoho->getSalesOrder($order['salesorder_id']);
                $soDetails = $detailsResp['salesorder'] ?? [];

                if (empty($soDetails)) continue;
                
                $soDetails['total_invoiced_amount'] = $order['total_invoiced_amount'];
                $soDetails['quantity_invoiced'] = $order['quantity_invoiced'];
                $totalSo++;

                $this->info("  ↳ Syncing Salesorder {$soDetails['salesorder_number']}...");
                $salesOrder = SalesOrder::upsertFromZoho($soDetails);
                // 🧾 Sync invoices related to this Sales Order
                // if (!empty($soDetails['invoices'])) {
                //     foreach ($soDetails['invoices'] as $invoiceSummary) {
                //         $invoiceId = $invoiceSummary['invoice_id'] ?? null;
                //         $totalgetSoSinvoice++;
                //         if ($invoiceId) {
                //             $this->info("  ↳ Syncing invoice {$invoiceSummary['invoice_number']}...");

                //             $invoiceResp = $zoho->getInvoices($invoiceId);
                //             $invoiceDetails = $invoiceResp['invoice'] ?? null;
                            
                //             if ($invoiceDetails) {
                //                 $ewaybillDetails = null;

                //                 if (!empty($invoiceDetails['ewaybill_id'])) {

                //                     $ewaybillId = $invoiceDetails['ewaybill_id'];

                //                     $this->info("    ↳ Fetching E-Waybill {$ewaybillId}...");

                //                     $ewayResp = $zoho->getEwaybill($ewaybillId);

                //                     $ewaybillDetails = $ewayResp['ewaybill'] ?? null;
                //                 }

                //                 $Invoice = SalesOrderInvoice::upsertFromZoho(
                //                     $invoiceDetails,
                //                     $salesOrder->id,
                //                     $salesOrder->zoho_salesorder_id,
                //                     $ewaybillDetails // pass null if not exists
                //                 );

                //                 $totalSoSinvoice++;

                //             }
                //         }
                //     }
                // }
            }

            $hasMore = $response['page_context']['has_more_page'] ?? false;
            $page++;

        } while ($hasMore);
        Log::info("Sync salesOders sttus",[
            "order_status" => $ost,
            "status" => $st,
            "both" => $both,
        ]);
        $this->info("🎉 Sync completed. Total imported/updated: totalSo :- {$totalSo}");
    }
}
