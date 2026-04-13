<?php

namespace App\Console\Commands;

use App\Models\PurchaseOrder;
use App\Services\ZohoBookService;
use Illuminate\Console\Command;

class ZohoSyncPurchaseOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:sync:purchaseOrder {--per_page=200}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ync Purchase Orders and related invoices from Zoho Books to local database';

    /**
     * Execute the console command.
     */
    public function handle(ZohoBookService $zoho)
    {
        $this->info('🚀 Starting Zoho Purchase Orders sync...');
        $perPage = (int) $this->option('per_page') ?: 200;
        $page = 1;
        $total = 0;

        do {
            $this->info("📄 Fetching page {$page}...");
            $response = $zoho->getAllPurchaseorders([
                'page' => $page,
                'per_page' => $perPage,
                'sort_order' => "A"
            ]);
            
            $purchaseOrders = $response['purchaseorders'] ?? [];
            if (empty($purchaseOrders)) {
                $this->info("✅ No more records found. Stopping.");
                break;
            }
            
            foreach ($purchaseOrders as $order) {
                $detailsResp = $zoho->getPurchaseorder($order['purchaseorder_id']);
                $poDetails = $detailsResp['purchaseorder'] ?? [];
                // dd($soDetails);
                if (empty($poDetails)) continue;
                
                PurchaseOrder::upsertFromZoho($poDetails);
                $total++;
                
            }

            $hasMore = $response['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);

        $this->info("🎉 Sync completed. Total imported/updated: {$total}");
    }
}
