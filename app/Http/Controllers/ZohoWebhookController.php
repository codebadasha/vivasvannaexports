<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\ZohoWebhook;
use App\Services\ZohoWebhookHandler;

class ZohoWebhookController extends Controller
{
    protected $config;
    protected $event;
    protected $module;

    public function __construct(Request $request)
    {
        $this->module = $request->route('module'); // {module} from route
        $this->event = $request->query('event') ?? $request->input('event');
        $secret = $request->query('secret');

        $this->config = ZohoWebhook::where('module_name', $this->module)
            ->where('event', $this->event)
            ->first();

        if (!$this->config || !$this->config->secret || $this->config->secret !== $secret) {
            Log::warning('Zoho webhook secret mismatch', [
                'module' => $this->module,
                'event' => $this->event,
                'secret' => $secret
            ]);

            abort(401, 'Unauthorized'); // will stop execution & return JSON
        }
    }

    public function handle(Request $request, ZohoWebhookHandler $handler)
    {
        $zohoId = $this->extractIdFromPayload($request->all());
        if (!$zohoId) {
            return response()->json(['message' => 'No record id found'], 422);
        }
        // By this point, validation is already done in __construct.
        $result = $handler->process($this->module, $this->event, $zohoId);

        return response()->json(['message' => $result]);
    }

    private function extractIdFromPayload(array $payload)
    {
        foreach (['item_id', 'invoice_id', 'salesorder_id', 'purchaseorder_id', 'customer_id', 'vendor_id'] as $key) {
            if (!empty($payload[$key])) {
                return $payload[$key];
            }
        }

        if (!empty($payload['data']['id'])) {
            return $payload['data']['id'];
        }

        return null;
    }
}
