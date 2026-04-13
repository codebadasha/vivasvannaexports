<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ZohoWebhookHandler;

class ProcessZohoWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $module;
    public $event;
    public $zohoId;

    public $timeout = 180;
    public $tries = 3;

    public function __construct($module, $event, $zohoId)
    {
        $this->module = $module;
        $this->event = $event;
        $this->zohoId = $zohoId;
    }

    public function handle(ZohoWebhookHandler $handler)
    {
        $handler->process($this->module, $this->event, $this->zohoId);
    }
}