<?php

namespace App\Console\Commands;

use App\Models\ZohoWebhook;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ZohoGenerateWebhookConfig extends Command
{
    protected $signature = 'zoho:generate-webhook-config {module?} {event?} {--force : Overwrite existing config}';
    protected $description = 'Generate secret and URL for Zoho webhook entries (all null ones or specific)';

    // -----------------------------------------------------------------
    // 1. List of modules + their Zoho name (as used in the webhook URL)
    // -----------------------------------------------------------------
    private $modules = [
        'vendor'        => 'vendors',          // Zoho = vendors
        'tax'           => 'taxes',            // Zoho = taxes
        'taxgroup'      => 'taxgroups',        // Zoho = taxgroups
        'salesorder'    => 'salesorders',      // Zoho = salesorders
        'purchaseorder' => 'purchaseorders',   // Zoho = purchaseorders
        'product'       => 'items',            // Zoho = items
    ];

    private $events = ['create', 'update', 'delete'];

    public function handle()
    {
        $moduleArg = $this->argument('module');
        $eventArg  = $this->argument('event');

        if ($moduleArg && $eventArg) {
            $this->processSpecific($moduleArg, $eventArg);
        } else {
            $this->processAll();
        }

        return 0;
    }

    // --------------------------------------------------------------
    // 2. Process ONE module+event (e.g. php artisan zoho:generate-webhook-config vendor create)
    // --------------------------------------------------------------
    private function processSpecific($module, $event)
    {
        $zohoName = $this->modules[strtolower($module)] ?? null;
        if (!$zohoName) {
            $this->error("Module '{$module}' not recognised.");
            return;
        }

        $existing = ZohoWebhook::where('module_name', $zohoName)
            ->where('event', $event)
            ->first();

        if (!$existing) {
            $existing = ZohoWebhook::create([
                'module_name' => $zohoName,
                'event'       => $event,
                'secret'      => null,
                'url'         => null,
            ]);
            $this->info("Created new entry for {$zohoName}.{$event}");
        }

        if ($existing->secret && $existing->url && !$this->option('force')) {
            $this->warn("Config already exists – use --force to overwrite.");
            return;
        }

        $this->generateForEntry($existing);
    }

    // --------------------------------------------------------------
    // 3. Process **ALL** modules × create / update / delete
    // --------------------------------------------------------------
    private function processAll()
    {
        $created = 0;
        $updated = 0;

        foreach ($this->modules as $local => $zoho) {
            foreach ($this->events as $event) {
                $entry = ZohoWebhook::firstOrNew([
                    'module_name' => $zoho,
                    'event'       => $event,
                ]);

                $needsGeneration = !$entry->exists ||
                                   (!$entry->secret || !$entry->url) ||
                                   $this->option('force');

                if ($needsGeneration) {
                    if (!$entry->exists) {
                        $entry->secret = null;
                        $entry->url    = null;
                        $entry->save();
                        $created++;
                    } else {
                        $updated++;
                    }

                    $this->generateForEntry($entry);
                }
            }
        }

        $this->info("Finished – {$created} created, {$updated} updated.");
    }

    // --------------------------------------------------------------
    // 4. Generate secret + URL (your original logic, unchanged)
    // --------------------------------------------------------------
    private function generateForEntry($entry)
    {
        $module = $entry->module_name;
        $event  = $entry->event;
        $secret = Str::random(32);

        // ----> CHANGE ONLY THIS LINE IF YOU SWITCH FROM NGROK <----
        $baseUrl = 'https://a022a3a5ea5f.ngrok-free.app' . '/webhooks/zoho/' . $module;
        // -----------------------------------------------------------

        $url = $baseUrl . '?event=' . $event . '&secret=' . $secret;

        $entry->update(['secret' => $secret, 'url' => $url]);

        $this->info("Generated/Updated config for {$module}.{$event}:");
        $this->line("Secret: {$secret}");
        $this->line("URL:    {$url}");
        $this->line(''); // blank line for readability
    }
}