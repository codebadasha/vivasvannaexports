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
    ];

    public function client(){
        return $this->hasOne(SupplierCompany::class,'zoho_contact_id','vendor_id');
    }

    /** 🔗 Relations */
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'sales_order_id');
    }

    /** 🧠 Upsert from Zoho API */
    public static function upsertFromZoho(array $data)
    {
        // dd($data);
        $order = self::updateOrCreate(
            ['purchaseorder_id' => $data['purchaseorder_id']],
            [
                'purchaseorder_number'   => $data['purchaseorder_number'] ?? null,
                'date' => !empty($data['date']) ? $data['date'] : null,
                'location_id'         => $data['location_id'] ?? null,
                'location_name'       => $data['location_name'] ?? null,
                'reference_number'    => $data['reference_number'] ?? null,
                'vendor_id'         => $data['vendor_id'] ?? null,
                'vendor_name'       => $data['vendor_name'] ?? null,
                'company_name'       => $data['company_name'] ?? null,
                'status'              => $data['status'] ?? null,
                'billed_status'       => $data['billed_status'] ?? null,
                'delivery_date' => !empty($data['delivery_date']) ? $data['delivery_date'] : null,
                'total'             => $data['total'] ?? 0,
                'sub_total'           => $data['sub_total'] ?? 0,
                'tax_total'           => $data['tax_total'] ?? 0,
                'discount_total'      => $data['discount_total'] ?? 0,
            ]
        );

        // 💼 Sync Line Items
        if (!empty($data['line_items'])) {
            foreach ($data['line_items'] as $line) {
                PurchaseOrderItem::upsertFromZoho($line, $data['purchaseorder_id']);
            }
        }

        return $order;
    }

}
