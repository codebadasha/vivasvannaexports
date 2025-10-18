<?php 
namespace App\Console\Commands;

use App\Models\ZohoWebhook;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ZohoGenerateWebhookConfig extends Command
{
    protected $signature = 'zoho:generate-webhook-config {module?} {event?} {--force : Overwrite existing config}';
    protected $description = 'Generate secret and URL for Zoho webhook entries from database (all null ones or specific)';

    public function handle()
    {
        $moduleArg = $this->argument('module');
        $eventArg = $this->argument('event');

        if ($moduleArg && $eventArg) {
            // Process specific module and event
            $this->processSpecific($moduleArg, $eventArg);
        } else {
            // Process all entries where secret and url are null (or all with --force)
            $query = ZohoWebhook::query();
            if (!$this->option('force')) {
                $query->whereNull('secret')->whereNull('url');
            }
            $entries = $query->get();

            if ($entries->isEmpty()) {
                $this->info('No entries need generation (all have secret and url, or use --force to overwrite all).');
                return 0;
            }

            foreach ($entries as $entry) {
                $this->generateForEntry($entry);
            }
            $this->info('Processed all eligible entries.');
        }

        return 0;
    }

    private function processSpecific($module, $event)
    {
        $existing = ZohoWebhook::where('module_name', $module)
            ->where('event', $event)
            ->first();

        if (!$existing) {
            // Create if missing with secret and url null
            $existing = ZohoWebhook::create([
                'module_name' => $module,
                'event' => $event,
                'secret' => null,
                'url' => null,
            ]);
            $this->info("Created new entry for $module.$event with null secret/url.");
        }

        if ($existing->secret && $existing->url && !$this->option('force')) {
            $this->warn("Config for $module.$event already exists: Secret: {$existing->secret}, URL: {$existing->url}");
            return;
        }

        $this->generateForEntry($existing);
    }

    private function generateForEntry($entry)
    {
        $module = $entry->module_name;
        $event = $entry->event;
        $secret = Str::random(32);
        $baseUrl = config('app.url') . '/webhooks/zoho/' . $module;
        $url = $baseUrl . '?event=' . $event . '&secret=' . $secret;

        $entry->update(['secret' => $secret, 'url' => $url]);

        $this->info("Generated/Updated config for $module.$event:");
        $this->line("Secret: $secret");
        $this->line("URL: $url");
        $this->info('Copy URL to Zoho Books webhook setup.');
    }
}