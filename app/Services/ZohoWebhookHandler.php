<?php

namespace App\Services;

use App\Models\ClientCompany;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\SalesOrderInvoice;
use App\Models\SupplierCompany;
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
            case 'items':
                Product::where('zoho_item_id', $zohoId)->delete();
                break;
            case 'invoices':
                SalesOrderInvoice::where('invoice_id', $zohoId)->delete();
                break;
            case 'customers':
                ClientCompany::where('zoho_id', $zohoId)->delete();
                break;
            case 'vendors':
                SupplierCompany::where('company_name ', $zohoId)->delete();
                break;
            case 'salesorders':
                SalesOrder::where('salesorder_id', $zohoId)->delete();
                break;
            case 'purchaseorders':
                PurchaseOrder::where('purchaseorder_id', $zohoId)->delete();
                break;
            default:
                Log::warning("Delete: Unknown module $module");
                return "Unknown module";
        }

        return "Deleted locally ($module:$zohoId)";
    }

    private function syncFromZoho(string $module, string $zohoId): string
    {
        switch ($module) {
            case 'items':
                $data = $this->zoho->getItem($zohoId);
                $productDetails =  $data["item"];
                Product::upsertFromZoho($productDetails);
                break;

            case 'invoices':
                $data = $this->zoho->getInvoices($zohoId);
                $invoiceDetails = $data['invoice'] ?? null;
                SalesOrderInvoice::upsertFromZoho($invoiceDetails);
                break;

            // case 'customers':
            //     $data = $this->zoho->getCustomer($zohoId);
            //     ClientCompany::upsertFromZoho($data);
            //     break;

            case 'vendors':
                $data = $this->zoho->getVendor($zohoId);
                $vendorDetails = $data['contact'] ?? null;
                SupplierCompany::upsertFromZoho($vendorDetails);
                break; //ohk

            case 'salesorders':
                $data = $this->zoho->getSalesOrder($zohoId);
                $soDetails = $data['salesorder'] ?? [];
                SalesOrder::upsertFromZoho($soDetails);
                break;

            case 'purchaseorders':
                $data = $this->zoho->getPurchaseOrder($zohoId);
                $poDetails = $data['purchaseorder'] ?? [];
                PurchaseOrder::upsertFromZoho($poDetails);
                break;

            default:
                Log::warning("Sync: Unknown module $module");
                return "Unknown module";
        }

        return "Synced ($module:$zohoId)";
    }
}
