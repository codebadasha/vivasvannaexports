<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Services\ZohoBookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ZohoUserSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0; // unlimited time

    public function handle(ZohoBookService $zoho)
    {
        $perPage = 200;

        $localCount = Admin::whereNot('role_id',1)->count();

        // Calculate start page
        $page = floor($localCount / $perPage) + 1;

        // Calculate skip in first page
        $skipInFirstPage = $localCount % $perPage;

        $isFirstPage = true;

        do {

            $response = $zoho->getAllUser([
                'page' => $page,
                'per_page' => $perPage,
                'sort_order' => "A"
            ]);

            $users = $response['users'] ?? [];

            if (empty($users)) {
                break;
            }

            // Skip already synced records
            if ($isFirstPage && $skipInFirstPage > 0) {
                $users = array_slice($users, $skipInFirstPage);
                $isFirstPage = false;
            }

            foreach ($users as $user) {
                if (empty($user)) continue;
                Admin::upsertFromZoho($user);
            }

            $hasMore = $response['page_context']['has_more_page'] ?? false;

            $page++;

        } while ($hasMore);
    }
}
