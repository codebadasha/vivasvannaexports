<?php

namespace App\Console\Commands;

use App\Models\SupplierCompany;
use App\Services\ZohoBookService;
use Illuminate\Console\Command;

class ZohoSyncVendor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:sync-vendor {--per_page=200}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Full sync of Zoho Vendor into local DB (initial import)';

    /**
     * Execute the console command.
     */
    public function handle(ZohoBookService $zoho)
    {
        $this->info('Starting Zoho vendor sync...');
        $perPage = (int)$this->option('per_page') ?: 200;
        $page = 1;
        $totalImported = 0;

        do {
            $this->info("Fetching page {$page}...");

            $resp = $zoho->getAllVendor([
                'page'     => $page,
                'per_page' => $perPage,
            ]);

            $vendors = $resp['contacts'] ?? [];

            if (empty($vendors)) {
                $this->warn("No vendors found on page {$page}, stopping.");
                break;
            }

            foreach ($vendors as $vendor) {
                $details = $zoho->getVendor($vendor['contact_id']);
                $vendorDetails = $details['contact'] ?? null;

                if (!$vendorDetails) {
                    $this->warn("No details found for vendor {$vendor['contact_id']}, skipping.");
                    continue;
                }

                SupplierCompany::upsertFromZoho($vendorDetails);
                $totalImported++;
            }

            $hasMore = $resp['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);

        $this->info("Zoho Vendor sync completed. Total imported/updated: {$totalImported}");
    }
}
