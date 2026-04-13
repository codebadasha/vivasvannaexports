<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ZohoBookService;
use App\Services\ZohoWebhookHandler;
use App\Models\ClientCompany;
use App\Models\ClientGstDetail;
use Illuminate\Support\Facades\Log;

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
    public function handle(ZohoBookService $zoho, ZohoWebhookHandler $handler)
    {
        $this->info('Starting Zoho Customers sync...');
        $perPage = (int)$this->option('per_page') ?: 200;
        $page = 1;
        $totalcustomer = 0;

        do {
            $this->info("Fetching page {$page}...");

            $resp = $zoho->getAllCustomer([
                'page'     => $page,
                'per_page' => $perPage,
                'sort_column' => "created_time"
            ]);

            $customers = $resp['contacts'] ?? [];

            if (empty($customers)) {
                $this->info("No customers found on page {$page}, stopping.");
                break;
            }

            foreach ($customers as $customer) {

                $this->info("  ↳ Syncing customer contactId :- {$customer['contact_id']}, gstn :- {$customer['gst_no']}...");
                $contactId = $customer['contact_id'];
                $gstNumber = $customer['gst_no'];

                if($contactId && $gstNumber){
                    $totalcustomer++;
                    $handler->process('customers', 'upsert', $contactId, true);
                }
            }

            $hasMore = $resp['page_context']['has_more_page'] ?? false;
            $page++;
        } while ($hasMore);

        $this->info("Zoho Products sync completed. Total imported/updated: {$totalcustomer}");
    }
}
