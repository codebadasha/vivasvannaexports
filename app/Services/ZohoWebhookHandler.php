<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Models\ZohoItem;
use App\Models\ZohoInvoice;
use App\Models\ZohoCustomer;
use App\Models\ZohoVendor;
use App\Models\ZohoSalesOrder;
use App\Models\ZohoPurchaseOrder;

class ZohoWebhookHandler
{
    protected $zoho;

    public function __construct(ZohoBookService $zoho)
    {
        $this->zoho = $zoho; // injected automatically by Laravel
    }

    public function process(string $module, string $event, string $zohoId): string
    {
        if (str_contains($event, 'delete')) {
            return $this->deleteLocal($module, $zohoId);
        }

        return $this->syncFromZoho($module, $zohoId);
    }

    private function deleteLocal(string $module, string $zohoId): string
    {
        switch ($module) {
            case 'items': ZohoItem::where('zoho_id', $zohoId)->delete(); break;
            case 'invoices': ZohoInvoice::where('zoho_id', $zohoId)->delete(); break;
            case 'customers': ZohoCustomer::where('zoho_id', $zohoId)->delete(); break;
            case 'vendors': ZohoVendor::where('zoho_id', $zohoId)->delete(); break;
            case 'salesorders': ZohoSalesOrder::where('zoho_id', $zohoId)->delete(); break;
            case 'purchaseorders': ZohoPurchaseOrder::where('zoho_id', $zohoId)->delete(); break;
            default: Log::warning("Delete: Unknown module $module"); return "Unknown module";
        }

        return "Deleted locally ($module:$zohoId)";
    }

    private function syncFromZoho(string $module, string $zohoId): string
    {
        switch ($module) {
            case 'items':
                $data = $this->zoho->getItem($zohoId);
                ZohoItem::upsertFromZoho($data);
                break;

            case 'invoices':
                $data = $this->zoho->getInvoice($zohoId);
                ZohoInvoice::upsertFromZoho($data);
                break;

            case 'customers':
                $data = $this->zoho->getCustomer($zohoId);
                ZohoCustomer::upsertFromZoho($data);
                break;

            case 'vendors':
                $data = $this->zoho->getVendor($zohoId);
                ZohoVendor::upsertFromZoho($data);
                break;

            case 'salesorders':
                $data = $this->zoho->getSalesOrder($zohoId);
                ZohoSalesOrder::upsertFromZoho($data);
                break;

            case 'purchaseorders':
                $data = $this->zoho->getPurchaseOrder($zohoId);
                ZohoPurchaseOrder::upsertFromZoho($data);
                break;

            default:
                Log::warning("Sync: Unknown module $module");
                return "Unknown module";
        }

        return "Synced ($module:$zohoId)";
    }
}
