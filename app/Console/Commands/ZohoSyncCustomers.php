<?php

namespace App\Console\Commands;


use App\Models\ClientCompany;
use App\Services\SurepassService;
use App\Services\ZohoBookService;
use Illuminate\Console\Command;

class ZohoSyncCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho:sync:customers {--per_page=200}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Full sync of Zoho Customers into local DB (initial import)';

    /**
     * Execute the console command.
     */
    public function handle(ZohoBookService $zoho, SurepassService $surepass)
    {
        $this->info('Starting Zoho Customers sync...');
        $perPage = (int)$this->option('per_page') ?: 200;
        $page = 1;
        $totalImported = 0;

        do {
            $this->info("Fetching page {$page}...");

            $resp = $zoho->getAllCustomer([
                'page'     => $page,
                'per_page' => $perPage,
            ]);

            $customers = $resp['contacts'] ?? [];

            if (empty($customers)) {
                $this->info("No customers found on page {$page}, stopping.");
                break;
            }

            foreach ($customers as $customer) {

                $response = $surepass->verificationProcess($customer['gst_no']);
                $data = $response->getData(true);
                if (empty($data['data'])) continue;

                $surepassData = $data['data'];
                $panNumber = strtoupper($surepassData['pan_number']);

                $customerDetails = $zoho->getCustomer($customer['contact_id'])['contact'] ?? [];

                $msmeCheck = $surepass->msmeVerification($panNumber);
                $msmeRegister = (!empty($msmeCheck['data']['udyam_exists']) && $msmeCheck['data']['udyam_exists'] === true) ? 1 : 0;

                ClientCompany::upsertFromZoho($customerDetails, $surepassData, $msmeRegister);
            }

            $hasMore = $resp['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);

        $this->info("Zoho Products sync completed. Total imported/updated: {$totalImported}");
    }
}
