<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemTax extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_item_id',
        'purchase_order_id',
        'tax_id',
        'tax_name',
        'tax_amount',
        'tax_percentage',
    ];

    public static function upsertFromZoho(array $tax, $purchaseOrderItemId, $purchaseOrderId)
    {
        return self::updateOrCreate(
            [
                'purchase_order_item_id' => $purchaseOrderItemId,
                'purchase_order_id' => $purchaseOrderId,
                'tax_id'              => $tax['tax_id'],
            ],
            [
                'tax_name'         => $tax['tax_name'] ?? null,
                'tax_amount'       => $tax['tax_amount'] ?? 0,
                'tax_percentage'   => $tax['tax_percentage'] ?? 0,
            ]
        );
    }
    
    public function item()
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'purchase_order_item_id');
    }
}
