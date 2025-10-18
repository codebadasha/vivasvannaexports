<?php

namespace App\Console\Commands;

use App\Models\ProductTax;
use App\Models\ProductTaxGroup;
use App\Services\ZohoBookService;
use Illuminate\Console\Command;

class ZohoSyncTaxGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:sync:tax-group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Full sync of Zoho Tax group into local DB (initial import)';

    /**
     * Execute the console command.
     */
    public function handle(ZohoBookService $zoho)
    {
        $this->info('Starting Zoho Tax group sync...');
        $totalImported = 0;

        $taxes = ProductTax::where("tax_type", "tax_group")->where("tax_specification", "intra")->get();
        foreach ($taxes as $tax) {
            $resp = $zoho->getTaxGroup($tax['tax_id']);
            $taxGroup = $resp['tax_group']['taxes'] ?? [];

            if (empty($taxGroup)) {
                $this->info("No tax group found stopping.");
                break;
            }

            foreach ($taxGroup as $tax) {
                $taxId = $tax['tax_id'];
                $resp = $zoho->getTax($taxId);
                $taxDetails =  $resp["tax"];

                if (!$taxDetails) {
                    $this->info("No tax datails found  skipp {$taxId}.");
                    continue;
                }
                $taxDetails['tax_group_id'] = $taxId;

                ProductTaxGroup::upsertFromZoho($taxDetails);
                $totalImported++;
            }
        }

        $this->info("Zoho Tax group sync completed. Total imported/updated: {$totalImported}");
    }
}
