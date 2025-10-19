<?php

namespace App\Console\Commands;

use App\Models\Tax;
use App\Services\ZohoBookService;
use Illuminate\Console\Command;

class ZohoSyncTaxes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:sync:taxes {--per_page=200}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Full sync of Zoho Taxes into local DB (initial import)';

    /**
     * Execute the console command.
     */
    public function handle(ZohoBookService $zoho)
    {
        $this->info('Starting Zoho Taxes sync...');
        $perPage = (int)$this->option('per_page') ?: 200;
        $page = 1;
        $totalImported = 0;

        do {
            $this->info("Fetching page {$page}...");

            $resp = $zoho->getAllTaxes([
                'page'     => $page,
                'per_page' => $perPage,
            ]);

            $taxes = $resp['taxes'] ?? [];

            if (empty($taxes)) {
                $this->info("No taxes found on page {$page}, stopping.");
                break;
            }

            foreach ($taxes as $tax) {
                $this->info("No taxes found on page {$tax['tax_id']}, stopping.");
                
                $resp = $zoho->getTax($tax['tax_id']);
                $taxDetails =  $resp["tax"];

                $tax['tax_name_formatted'] = $taxDetails['tax_name_formatted'];
                $tax['tax_account_id'] = $taxDetails['tax_account_id'];
                $tax['tds_payable_account_id'] = $taxDetails['tds_payable_account_id'];
                $tax['is_state_cess'] = $taxDetails['is_state_cess'];
                $tax['description'] = $taxDetails['description'];

                Tax::upsertFromZoho($tax);
                $totalImported++;
            }

            $hasMore = $resp['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);

        $this->info("Zoho Taxes sync completed. Total imported/updated: {$totalImported}");
    }
}
