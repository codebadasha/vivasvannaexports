<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderItemTax extends Model
{
    protected $fillable = [
        'sales_order_item_id',
        'sales_order_id',
        'tax_id',
        'tax_name',
        'tax_amount',
        'tax_percentage',
        'tax_specific_type',
    ];

    public static function upsertFromZoho(array $tax, $salesOrderItemId, $salesOrderId)
    {
        return self::updateOrCreate(
            [
                'sales_order_item_id' => $salesOrderItemId,
                'sales_order_id'      => $salesOrderId,
                'tax_id'              => $tax['tax_id'],
            ],
            [
                'tax_name'         => $tax['tax_name'] ?? null,
                'tax_amount'       => $tax['tax_amount'] ?? 0,
                'tax_percentage'   => $tax['tax_percentage'] ?? 0,
                'tax_specific_type'=> $tax['tax_specific_type'] ?? null,
            ]
        );
    }
    
    public function item()
    {
        return $this->belongsTo(SalesOrderItem::class, 'sales_order_item_id');
    }
}
