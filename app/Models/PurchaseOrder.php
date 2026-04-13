<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'purchaseorder_id',
        'purchaseorder_number',
        'location_id',
        'location_name',
        'reference_number',
        'vendor_id',
        'vendor_name',
        'company_name',
        'date',
        'status',
        'billed_status',
        'delivery_date',
        'total',
        'sub_total',
        'tax_total',
        'discount_total',
        'submitted_date',
        'submitted_by',
        'submitted_by_name',
        'submitted_by_email',
        'submitter_id',
        'approver_id',
        'order_status',
        'current_sub_status',
        'exchange_rate',
        'total_quantity',
        'sub_total_inclusive_of_tax',
        'discount_percent',
    ];

    public function client(){
        return $this->hasOne(SupplierCompany::class,'zoho_contact_id','vendor_id');
    }

    /** 🔗 Relations */
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id');
    }

    public function documents()
    {
        return $this->hasMany(PurchaseOrderDocument::class);
    }

    /** 🧠 Upsert from Zoho API */
    public static function upsertFromZoho(array $data)
    {
        // dd($data);
        $PurchaseOrder = self::updateOrCreate(
            ['purchaseorder_id' => $data['purchaseorder_id']],
            [
                'purchaseorder_number'  => $data['purchaseorder_number'] ?? null,
                'date'                  => !empty($data['date']) ? $data['date'] : null,
                'location_id'           => $data['location_id'] ?? null,
                'location_name'         => $data['location_name'] ?? null,
                'reference_number'      => $data['reference_number'] ?? null,
                'vendor_id'             => $data['vendor_id'] ?? null,
                'vendor_name'           => $data['vendor_name'] ?? null,
                'company_name'          => $data['vendor_name'] ?? null,
                'status'                => $data['status'] ?? null,
                'billed_status'         => $data['billed_status'] ?? null,
                'delivery_date'         => !empty($data['delivery_date']) ? $data['delivery_date'] : null,
                'total'                 => $data['total'] ?? 0,
                'sub_total'             => $data['sub_total'] ?? 0,
                'tax_total'             => $data['tax_total'] ?? 0,
                'discount_total'        => $data['discount_total'] ?? 0,
                'submitted_date'        => !empty($data['submitted_date']) ? $data['submitted_date'] : null,
                'submitted_by'          => $data['submitted_by'] ?? null,
                'submitted_by_name'     => $data['submitted_by_name'] ?? null,
                'submitted_by_email'    => $data['submitted_by_email'] ?? null,
                'submitter_id'          => !empty($data['submitter_id']) ? (int) $data['submitter_id'] : null,
                'approver_id'           => !empty($data['approver_id']) ? (int) $data['approver_id'] : null,
                'order_status'          => $data['order_status'] ?? null,
                'current_sub_status'    => $data['current_sub_status'] ?? null,
                'exchange_rate'         => $data['exchange_rate'] ?? 1,
                'total_quantity'        => $data['total_quantity'] ?? 0,
                'sub_total_inclusive_of_tax' => $data['sub_total_inclusive_of_tax'] ?? 0,
                'discount_percent'      => $data['discount_percent'] ?? 0,
            ]
        );

        if (!empty($data['documents'])) {
            $incomingIds = collect($data['documents'])
                ->pluck('document_id')
                ->toArray();

            // 🗑 Delete documents that are NOT in incoming list
            $PurchaseOrder->documents()
                ->whereNotIn('document_id', $incomingIds)
                ->delete();
            foreach ($data['documents'] as $doc) {
                PurchaseOrderDocument::updateOrCreate(
                    [
                        'purchase_orders_id' => $PurchaseOrder->id,
                        'document_id'     => $doc['document_id'],
                    ],
                    [
                        'file_name'        => $doc['file_name'] ?? null,
                        'file_type'        => $doc['file_type'] ?? null,
                        'attachment_order' => $doc['attachment_order'] ?? null,
                    ]
                );
            }
        }        
        
        if (!empty($data['line_items'])) {
            foreach ($data['line_items'] as $line) {
                PurchaseOrderItem::upsertFromZoho($line, $data['purchaseorder_id']);
            }
        }

        return $PurchaseOrder;
    }

}
