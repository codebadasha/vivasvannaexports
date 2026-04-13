<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bank;
use App\Services\PerfiosService;
use Illuminate\Support\Facades\DB;

class PerfiosSyncBanks extends Command
{
    /**
     * Command Signature
     */
    protected $signature = 'perfios:sync:banks';

    /**
     * Command Description
     */
    protected $description = 'Sync Bank Institutions from Perfios API to local database';

    /**
     * Execute the console command.
     */
    public function handle(PerfiosService $perfios)
    {
        $this->info('🚀 Starting Perfios Bank sync...');

        try {

            $response = $perfios->listInstitutions();

            $institutions = $response['institutions']['institution'] ?? [];

            if (empty($institutions)) {
                $this->warn('⚠ No institutions found.');
                return Command::SUCCESS;
            }

            $total = 0;

            DB::transaction(function () use ($institutions, &$total) {

                foreach ($institutions as $institution) {

                    if (
                        empty($institution) ||
                        ($institution['institutionType'] ?? '') !== 'bank'
                    ) {
                        continue;
                    }

                    Bank::updateOrCreate(
                        ['perfios_institution_id' => $institution['id']],
                        ['name' => $institution['name']]
                    );

                    $total++;
                }
            });

            $this->info("🎉 Sync completed. Total banks synced: {$total}");

        } catch (\Exception $e) {

            $this->error('❌ Sync failed.');
            $this->error($e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
