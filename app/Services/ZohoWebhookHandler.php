<?php

namespace App\Services;

use App\Models\ClientCompany;
use App\Models\ClientGstDetail;
use App\Models\State;
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
use App\Models\SalesOrderInvoiceItem;
use Illuminate\Support\Facades\DB;
use App\Helpers\MailHelper;
use App\Services\SurepassService;

class ZohoWebhookHandler
{
    protected $zoho;
    protected $surepass;

    public function __construct(ZohoBookService $zoho, SurepassService $surepass)
    {
        $this->zoho = $zoho; // injected automatically by Laravel
        $this->surepass = $surepass; // injected automatically by Laravel
    }

    public function process(string $module, string $event, string $zohoId, bool $is_sync = false): string
    {
        
        if (str_contains($event, 'delete')) {
            $this->deleteLocal($module, $zohoId);
        }else{
            $this->syncFromZoho($module, $zohoId, $is_sync);
        }

        Log::info("Completed zoho webhook process for {$module} :- {$zohoId}");
        return "Synced ($module:$zohoId)";
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
                ClientCompany::where('zoho_contact_id', $zohoId)->delete();
                break;
            case 'vendors':
                SupplierCompany::where('zoho_contact_id ', $zohoId)->delete();
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

    private function syncFromZoho(string $module, string $zohoId, bool $is_sync): string
    {  
        switch ($module) {
            case 'items':
                $data = $this->zoho->getItem($zohoId);
                $productDetails =  $data["item"];
                Product::upsertFromZoho($productDetails);
                break;

            case 'invoices':
                
                $this->syncInvoice($zohoId, $is_sync);
                break;

            case 'customers':
                $this->syncCustomer($zohoId, $is_sync);
                break;

            case 'vendors':
                $data = $this->zoho->getVendor($zohoId);
                $vendorDetails = $data['contact'] ?? null;
                SupplierCompany::upsertFromZoho($vendorDetails);
                break; //ohk

            case 'salesorders':
                $this->syncSalesOrder($zohoId, $is_sync);
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

    private function syncCustomer(string $contactId, bool $is_sync): void
    {
        DB::transaction(function () use ($contactId, $is_sync) {
            $customerData = $this->zoho->getCustomer($contactId)['contact'] ?? [];
            $gstNumber = $customerData['gst_no'];

            $existingCompany = ClientCompany::where('gstn', $gstNumber)->first();
            $companygGstDetails = ClientGstDetail::where('gstn', $gstNumber)->first();

            Log::warning('check existingCompany and companygGstDetails', 
                [
                    'zoho gst' => $gstNumber ?? null,
                    'existingCompany_gst' => $existingCompany->gstn ?? null,
                    'companygGstDetails_gst' => $companygGstDetails->gstn ?? null
                ]
            );

            if ($existingCompany && $companygGstDetails) {
                Log::info('Customer already exists - Updating contact persons only', ['gstin' => $gstNumber]);

                $firstName = $customerData['first_name'] ?? '';
                $lastName  = $customerData['last_name'] ?? '';
                $name      = trim($firstName . ' ' . $lastName);
                $email     = $customerData['email'] ?? null;

                $normalizedMobile = $existingCompany->normalizeMobile($customerData['mobile'] ?? null);

                $companyData = [
                    'mobile_number' => $normalizedMobile ?? '',
                    'email' => $email,
                ];

                if(!empty($name)){
                    $companyData['director_name'] = $name;
                }

                $existingCompany->update($companyData);

                $contactDataForUpsert = [
                    'company'           => $existingCompany,
                    'zoho_contacts'     => $customerData['contact_persons'] ?? [],
                    'surepass_contacts' => [],
                    'zoho_contact_id'   => $customerData['contact_id'] ?? null,
                ];

                ClientCompany::contactPersonsUpsert($contactDataForUpsert);

                return;
            }
            
            Log::info('New customer from Zoho - Starting full sync', ['gstin' => $gstNumber]);

            $gstCheck = $this->surepass->gstVerification($gstNumber);
            if (!$gstCheck['status']) {
                Log::error('ZOHO Customers Sync Skip GSTIN validation failed', [
                    'gstin' => $gstNumber,
                    'error' => $gstCheck['message'] ?? 'Unknown error'
                ]);
                return;
            }

            $gstData = $gstCheck['data'];
            $business_name = $gstData['business_name'];
            $panNumber = strtoupper($gstData['pan_number']);
            $cinNumber = null;

            $address = $gstData['contact_details']['principal']['address'] ?? '';
            $addressComponents = array_map('trim', explode(',', $address));
            $stateName = $addressComponents[count($addressComponents) - 2] ?? null;
            $state = State::select('id')->where('name', $stateName)->first();
            $stateId = $state ? $state->id : 0;
            
            $companyData = [
                'director_name' => $gstData['promoters'],
                'pan_number' => $panNumber,
                'company_name' => $business_name,
                'mobile_number' => $gstData['contact_details']['principal']['mobile'],
                'email' => $gstData['contact_details']['principal']['email'],
                'address' => $address,
                'state_id' => $stateId,
                'gstn' => $gstNumber,
                'cin' => $cinNumber,
                'msme_register' => 0,
                'constitution_of_business' => $gstData['constitution_of_business']
            ];
            $promoters = !empty($gstData['promoters']) ? json_encode($gstData['promoters']) : null;

            $gstDetailsData = [
                'gstn' => $gstNumber,
                'pan' => $panNumber,
                'cin' => $cinNumber,
                'business_name' => $business_name ?? null,
                'legal_name' => $gstData['legal_name'] ?? null,
                'constitution_of_business' => $gstData['constitution_of_business'] ?? null,
                'taxpayer_type' => $gstData['taxpayer_type'] ?? null,
                'gstin_status' => $gstData['gstin_status'] ?? null,
                'center_jurisdiction' => $gstData['center_jurisdiction'] ?? null,
                'state_jurisdiction' => $gstData['state_jurisdiction'] ?? null,
                'date_of_registration' => !empty($gstData['date_of_registration'])
                    ? date('Y-m-d', strtotime($gstData['date_of_registration']))
                    : null,
                'nature_of_business' => $gstData['nature_of_business'] ?? null,
                'nature_bus_activities' => !empty($gstData['nature_bus_activities'])
                    ? json_encode($gstData['nature_bus_activities'])
                    : null,
                'promoters' => $promoters,
                'annual_turnover' => $gstData['annual_turnover'] ?? null,
                'annual_turnover_fy' => $gstData['annual_turnover_fy'] ?? null,
                'aadhaar_validation' => $gstData['aadhaar_validation'] ?? null,
                'aadhaar_validation_date' => !empty($gstData['aadhaar_validation_date'])
                    ? date('Y-m-d', strtotime($gstData['aadhaar_validation_date']))
                    : null,
                'einvoice_status' => $gstData['einvoice_status'] ?? false,
            ];

            if ($companygGstDetails) {
                $companygGstDetails->update($gstDetailsData);
                Log::info("existing customer company gst data Updated", ['id' => $companyGst->id, 'gstn' => $gstNumber]);
            } else {
                $companygGstDetails = ClientGstDetail::create($gstDetailsData);
                Log::info("new customer company gst data Created", ['id' => $companyGst->id, 'gstn' => $gstNumber]);
            }
            
            $company = ClientCompany::upsertFromZoho($customerData, $companyData);

            if ($companyGst) {
                $companyGst->update(['client_company_id' => $company->id]);
            }
            
            Log::info('ZOHO Customers added ', [
                    'gstin' => $gstNumber,
                    'error' => $gstCheck['message'] ?? 'Unknown error'
            ]);

        });
    }

    private function syncInvoice(string $zohoId, bool $is_sync): void
    {
        DB::transaction(function () use ($zohoId, $is_sync) {

            $data = $this->zoho->getInvoices($zohoId);
            $invoiceDetails = $data['invoice'] ?? null;
            $status = ["signed","paid","overdue",'approved'];
            if (!$invoiceDetails) {
                Log::info("Invoice Not found in zoho book :- {$zohoId}");
                return;
            }

            // 🔥 Check before insert
            $invoiceExists = SalesOrderInvoice::where(
                'invoice_id',
                $invoiceDetails['invoice_id']
            )->exists();

            if(!$is_sync && !$invoiceExists && !in_array($invoiceDetails['status'], $status)){
                Log::info("webhook New invoice Skipping {$zohoId} - {$is_sync} - {$invoiceExists} {invoiceDetails} status notssss approved current status is {$invoiceDetails['status']}");
                return;
            }

            $soQuery = SalesOrder::query();

            if(!empty($invoiceDetails['salesorder_id'])){
                $soQuery->where('zoho_salesorder_id',$invoiceDetails['salesorder_id']);
            }else{
                $soQuery->where('salesorder_number',$invoiceDetails['reference_number']);
            }
            
            $salesOrder = $soQuery->first();

            // if (!$salesOrder) {
            //     Log::info("Sync SalesOrder not found for invoice Skipping " ,["invoice_id" => $zohoId, "invoice_Number"=>$invoiceDetails['invoice_number'], "invoice_ref" =>$invoiceDetails['reference_number'], "salesorder_number" => $invoiceDetails['salesorder_number']]);
            //     return;
            // }

            $ewaybillDetails = null;
            if (!empty($invoiceDetails['ewaybill_id'])) {
                $ewaybillId = $invoiceDetails['ewaybill_id'];
                $ewayResp = $this->zoho->getEwaybill($ewaybillId);
                $ewaybillDetails = $ewayResp['ewaybill'] ?? null;
            }

            $invoice = SalesOrderInvoice::upsertFromZoho(
                $invoiceDetails,
                $salesOrder->id ?? null,
                $salesOrder->zoho_salesorder_id ?? null,
                $ewaybillDetails
            );

            if ($salesOrder) {
                $this->recalculateSalesOrderTotals($salesOrder);
            }
            // 🔥 Send mail ONLY if new
            if (!$invoiceExists && !$is_sync) {
                Log::info("come for invoice mail: " . $invoice->invoice_number);
                $subject = "New Invoice Generated – $invoice->invoice_number";
                $viewFile = 'mail-template.client-new-invoice-notification';
                $clientId = $invoice->customer_id;
                $data = [
                    'number' => $invoice->invoice_number,
                    'so_number' => $salesOrder->salesorder_number,
                    'invoice_number' => $invoice->invoice_number,
                    'invoice_date' => $invoice->date,
                    'due_date' => $invoice->due_date,
                    'total_amount' => $invoice->total,
                ];
                $this->sendClientMail($clientId, $subject, $viewFile, $data, 'Invoice');
            }

        });
    }

    private function syncSalesOrder(string $zohoId): void
    {
        DB::transaction(function () use ($zohoId) {

            $data = $this->zoho->getSalesOrder($zohoId);
            $soDetails = $data['salesorder'] ?? [];

            // 🔥 Check before insert
            $exists = SalesOrder::where(
                'zoho_salesorder_id',
                $zohoId
            )->exists();

            if(!$exists && strtolower($soDetails['order_status']) != 'approved'){
                Log::info("webhook New salesorder Skipping {$zohoId} - status not approved current status is {$soDetails['order_status']}");
                return;
            }

            // Upsert
            $salesOrder = SalesOrder::upsertFromZoho($soDetails);

            // 🔥 Send mail ONLY if new
            if ($salesOrder) {
                $this->recalculateSalesOrderTotals($salesOrder);
            }

            if (!$exists && $salesOrder) {
                $subject = "New Sales Order Created – $salesOrder->salesorder_number";
                $viewFile = 'mail-template.client-new-sales-order-notification';
                $clientId = $salesOrder->customer_id;
                $data = [
                    'number' => $salesOrder->salesorder_number,
                    'so_number' => $salesOrder->salesorder_number,
                    'order_date' => $salesOrder->date,
                    'total_amount' => $salesOrder->total,
                ];

               $this->sendClientMail($clientId, $subject, $viewFile, $data, 'Sales Order');
            }   

        });
    }

    private function recalculateSalesOrderTotals(SalesOrder $salesOrder): void
    {
        $totalInvoicedAmount = SalesOrderInvoice::where('sales_order_id', $salesOrder->id)
            ->whereNotIn('status', ['draft','void','viewed'])
            ->sum('total');

        $quantityInvoiced = SalesOrderInvoiceItem::whereHas('invoice', function ($q) use ($salesOrder) {
            $q->where('sales_order_id', $salesOrder->id);
        })->sum('quantity');

        $salesOrder->update([
            'total_invoiced_amount' => $totalInvoicedAmount,
            'quantity_invoiced'     => $quantityInvoiced,
        ]);
    }

    private function sendClientMail(string $clientId, $subject, string $viewFile, array $data = [], $type): void
    {
        try {

            if (!$clientId) {
                return;
            }
            $client = ClientCompany::where('zoho_contact_id', $clientId)->first();
            $response = MailHelper::send(
                            $client->email,
                            $subject,
                            $viewFile,
                            $data
                        );
            if (!$response['status']) {
                Log::error("New $type Mail failed for {$data['number']}: " . $response['message']);
                return;
            }

            Log::info("New $type created Mail send successfully to - {$client->email} :-" . $data['number']);

        } catch (\Throwable $e) {
            Log::error("new $type Mail sending failed {$data['number']}:-" . $e->getMessage());
        }
    }
}
