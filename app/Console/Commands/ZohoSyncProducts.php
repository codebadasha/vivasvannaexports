<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Services\ZohoBookService;
use Illuminate\Console\Command;

class ZohoSyncProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:sync:products {--per_page=200}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Full sync of Zoho Products into local DB (initial import)';

    /**
     * Execute the console command.
     */
    public function handle(ZohoBookService $zoho)
    {
        $this->info('Starting Zoho Products sync...');
        $perPage = (int)$this->option('per_page') ?: 200;
        $page = 1;
        $totalImported = 0;

        do {
            $this->info("Fetching page {$page}...");

            $resp = $zoho->getAllItem([
                'page'     => $page,
                'per_page' => $perPage,
            ]);

            $Products = $resp['items'] ?? [];

            if (empty($Products)) {
                $this->info("No Products found on page {$page}, stopping.");
                break;
            }

            foreach ($Products as $Product) {

                $resp = $zoho->getItem($Product['item_id']);
                $productDetails =  $resp["item"];

                Product::upsertFromZoho($productDetails);
                $totalImported++;
            }

            $hasMore = $resp['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);

        $this->info("Zoho Products sync completed. Total imported/updated: {$totalImported}");
    }
}
