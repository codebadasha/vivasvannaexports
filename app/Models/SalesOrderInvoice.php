<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SalesOrderInvoiceEwayBill;
use App\Models\SalesOrderInvoiceDocument;
use App\Models\Investor;
use Carbon\Carbon;



class SalesOrderInvoice extends Model
{
    protected $fillable = [
        'sales_order_id',
        'invoice_id',
        'invoice_number',
        'zoho_salesorder_id',
        'date',
        'due_date',
        'customer_id',
        'customer_name',
        'reference_number',
        'sub_total',
        'tax_total',
        'discount_total',
        'total',
        'balance',
        'status',
        'current_sub_status',
        'created_by_id',
        'created_by_name',
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'sub_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'total' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function items()
    {
        return $this->hasMany(SalesOrderInvoiceItem::class, 'invoice_id');
    }

    public function documents()
    {
        return $this->hasMany(SalesOrderInvoiceDocument::class, 'invoice_id');
    }

    public function ewayBills()
    {
        return $this->hasOne(
            SalesOrderInvoiceEwayBill::class,
            'invoice_id'
        );
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id');
    }
    /*
    |--------------------------------------------------------------------------
    | Zoho Upsert
    |--------------------------------------------------------------------------
    */

    public static function upsertFromZoho(array $data, $salesOrderId, $zohoSalesOrderId, $ewaybillDetails)
    {        
        $invoice = self::updateOrCreate(
            ['invoice_id' => $data['invoice_id']],
            [
                'sales_order_id'    => $salesOrderId,
                'invoice_number'    => $data['invoice_number'] ?? null,
                'zoho_salesorder_id'=> $zohoSalesOrderId,
                'date'              => !empty($data['date']) ? $data['date'] : null,
                'due_date'          => !empty($data['due_date']) ? $data['due_date'] : null,
                // 'date'              => $data['date'] ?? null,
                // 'due_date'          => $data['due_date'] ?? null,
                'customer_id'       => $data['customer_id'] ?? null,
                'customer_name'     => $data['customer_name'] ?? null,
                'reference_number'  => $data['reference_number'] ?? null,
                'sub_total'         => $data['sub_total'] ?? 0,
                'tax_total'         => $data['tax_total'] ?? 0,
                'discount_total'    => $data['discount_total'] ?? 0,
                'total'             => $data['total'] ?? 0,
                'balance'           => $data['balance'] ?? 0,
                'status'            => $data['status'] ?? null,
                'current_sub_status'=> $data['current_sub_status'] ?? null,
                'created_by_id'     => !empty($data['created_by_id']) ? (int) $data['created_by_id'] : null,
                'created_by_name'   => $data['created_by_name'] ?? null,
            ]
        );

        if (!empty($data['line_items'])) {
            foreach ($data['line_items'] as $lineItem) {
                SalesOrderInvoiceItem::upsertFromZoho($lineItem, $invoice->id);
            }
        }

        // Sync Documents
        if (!empty($data['documents'])) {
            $incomingIds = collect($data['documents'])
                ->pluck('document_id')
                ->toArray();

            // 🗑 Delete documents that are NOT in incoming list
            $invoice->documents()
                ->whereNotIn('document_id', $incomingIds)
                ->delete();
            foreach ($data['documents'] as $doc) {
                SalesOrderInvoiceDocument::updateOrCreate(
                    [
                        'invoice_id'  => $invoice->id,
                        'document_id' => $doc['document_id'],
                    ],
                    [
                        'file_name'        => $doc['file_name'] ?? null,
                        'file_type'        => $doc['file_type'] ?? null,
                        'attachment_order' => $doc['attachment_order'] ?? null,
                    ]
                );
            }
        }

        // Sync Eway Bills
        if (!empty($ewaybillDetails)) {
                $invoice->ewayBills()
                    ->whereNot('ewaybill_id',$data['ewaybill_id'])->delete();

                $ewaybill = SalesOrderInvoiceEwayBill::updateOrCreate(
                    [
                        'invoice_id'  => $invoice->id,
                        'ewaybill_id' => $ewaybillDetails['ewaybill_id'],
                    ],
                    [
                        'entity_id'                  => $ewaybillDetails['entity_id'] ?? null,
                        'entity_type'                => $ewaybillDetails['entity_type'] ?? null,
                        'entity_number'              => $ewaybillDetails['entity_number'] ?? null,
                        'entity_date_formatted'      => $ewaybillDetails['entity_date_formatted'] ?? null,
                        'entity_status'              => $ewaybillDetails['entity_status'] ?? null,
                        'supplier_gstin'             => $ewaybillDetails['supplier_gstin'] ?? null,
                        'customer_name'              => $ewaybillDetails['customer_name'] ?? null,
                        'customer_gstin'             => $ewaybillDetails['customer_gstin'] ?? null,
                        'ewaybill_number'            => $ewaybillDetails['ewaybill_number'] ?? null,
                        'ewaybill_date'              => !empty($ewaybillDetails['ewaybill_date']) ? Carbon::parse($ewaybillDetails['ewaybill_date']) : null,
                        'ewaybill_expiry_date'       => !empty($ewaybillDetails['ewaybill_expiry_date']) ? Carbon::parse($ewaybillDetails['ewaybill_expiry_date']) : null,
                        'ewaybill_start_date'       => !empty($ewaybillDetails['ewaybill_start_date']) ? Carbon::parse($ewaybillDetails['ewaybill_start_date']) : null,
                        'ewaybill_status'            => $ewaybillDetails['ewaybill_status'] ?? null,
                        'ewaybill_status_formatted'  => $ewaybillDetails['ewaybill_status_formatted'] ?? null,
                        'ewaybill_type'              => $ewaybillDetails['ewaybill_type'] ?? null,
                        'validity_days'              => !empty($ewaybillDetails['validity_days']) ?? 0,
                        'sub_supply_type'            => $ewaybillDetails['sub_supply_type'] ?? null,
                        'distance'                   => !empty($ewaybillDetails['distance']) ?? 0,
                        'transporter_id'             => $ewaybillDetails['transporter_id'] ?? null,
                        'transporter_name'           => $ewaybillDetails['transporter_name'] ?? null,
                        'transporter_license'        => $ewaybillDetails['transporter_license'] ?? null,
                        'transporter_registration_id'=> $ewaybillDetails['transporter_registration_id'] ?? null,
                        'place_of_dispatch'          => $ewaybillDetails['place_of_dispatch'] ?? null,
                        'place_of_delivery'          => $ewaybillDetails['place_of_delivery'] ?? null,
                        'ship_to_state_code'         => $ewaybillDetails['ship_to_state_code'] ?? null,
                        'entity_total'               => $ewaybillDetails['entity_total'] ?? 0,
                        'vehicle_details'            => !empty($ewaybillDetails['vehicle_details']) ? json_encode($ewaybillDetails['vehicle_details']) : null,
                    ]
                );
        }else{
            $invoice->ewayBills()->delete();
        }

        return $invoice;
    }
}
