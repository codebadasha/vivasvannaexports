<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

   use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'item_id',
        'line_item_id',
        'sku',
        'name',
        'description',
        'item_order',
        'bcy_rate',
        'rate',
        'quantity',
        'unit',
        'discount',
        'tax_id',
        'tax_name',
        'tax_type',
        'tax_percentage',
        'item_total',
        'product_type',
        'item_type',
        'hsn_or_sac'
    ];

    /** 🔗 Relations */
    public function PurchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function taxes()
    {
        return $this->hasMany(PurchaseOrderItemTax::class);
    }

    /** 🧠 Upsert from Zoho */
    public static function upsertFromZoho(array $data, $purchaseOrderId)
    {
        $item = self::updateOrCreate(
            [
                'purchase_order_id' => $purchaseOrderId,
                'item_id'        => $data['item_id'],
            ],
            [
                'line_item_id'       => $data['line_item_id'] ?? null,
                'sku'                => $data['sku'] ?? null,
                'name'               => $data['name'] ?? null,
                'description'        => $data['description'] ?? null,
                'item_order'         => $data['item_order'] ?? null,
                'bcy_rate'           => $data['bcy_rate'] ?? 0,
                'rate'               => $data['rate'] ?? 0,
                'quantity'           => $data['quantity'] ?? 0,
                'unit'               => $data['unit'] ?? null,
                'discount'           => $data['discount'] ?? 0,
                'tax_id'             => $data['tax_id'] ?? null,
                'tax_name'           => $data['tax_name'] ?? null,
                'tax_type'           => $data['tax_type'] ?? null,
                'tax_percentage'     => $data['tax_percentage'] ?? null,
                'item_total'         => $data['item_total'] ?? 0,
                'product_type'     => $data['product_type'] ?? null,
                'item_type'          => $data['item_type'] ?? null,
                'hsn_or_sac'         => $data['hsn_or_sac'] ?? null,
            ]
        );

        // 💰 Sync Taxes
        if (!empty($data['line_item_taxes']) && !empty($data['item_id'])) {

            foreach ($data['line_item_taxes'] as $tax) {
                PurchaseOrderItemTax::upsertFromZoho($tax, $data['item_id'], $purchaseOrderId);
            }
        }

        return $item;
    }
}
