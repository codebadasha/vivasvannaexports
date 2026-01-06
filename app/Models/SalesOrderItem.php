<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_order_id',
        'line_item_id',
        'variant_id',
        'item_id',
        'product_id',
        'sku',
        'name',
        'group_name',
        'description',
        'item_order',
        'bcy_rate',
        'rate',
        'sales_rate',
        'quantity',
        'quantity_manuallyfulfilled',
        'unit',
        'discount_amount',
        'discount',
        'tax_id',
        'tax_name',
        'tax_type',
        'tax_percentage',
        'item_total',
        'item_sub_total',
        'product_type',
        'line_item_type',
        'item_type',
        'hsn_or_sac',
        'is_invoiced',
        'quantity_invoiced',
        'quantity_backordered',
        'quantity_cancelled'
    ];

    /** 🔗 Relations */
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id', 'salesorder_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'zoho_item_id');
    }

    public function taxes()
    {
        return $this->hasMany(SalesOrderItemTax::class);
    }

    /** 🧠 Upsert from Zoho */
    public static function upsertFromZoho(array $data, $salesOrderId)
    {
        $item = self::updateOrCreate(
            [
                'sales_order_id' => $salesOrderId,
                'item_id'        => $data['item_id'],
            ],
            [
                'line_item_id'       => $data['line_item_id'] ?? null,
                'variant_id'         => $data['variant_id'] ?? null,
                'product_id'         => $data['product_id'] ?? null,
                'sku'                => $data['sku'] ?? null,
                'name'               => $data['name'] ?? null,
                'description'               => $data['description'] ?? null,
                'group_name'         => $data['group_name'] ?? null,
                'item_order'         => $data['item_order'] ?? null,
                'bcy_rate'           => $data['bcy_rate'] ?? 0,
                'rate'               => $data['rate'] ?? 0,
                'sales_rate'         => $data['sales_rate'] ?? 0,
                'quantity'           => $data['quantity'] ?? 0,
                'quantity_manuallyfulfilled'    => $data['quantity_manuallyfulfilled'] ?? 0,
                'unit'               => $data['unit'] ?? null,
                'discount'           => $data['discount'] ?? 0,
                'discount_amount'    => $data['discount_amount'] ?? 0,
                'tax_id'             => $data['tax_id'] ?? null,
                'tax_name'           => $data['tax_name'] ?? null,
                'tax_type'           => $data['tax_type'] ?? null,
                'tax_percentage'     => $data['tax_percentage'] ?? null,
                'item_total'         => $data['item_total'] ?? 0,
                'item_sub_total'     => $data['item_sub_total'] ?? 0,
                'product_type'       => $data['product_type'] ?? null,
                'line_item_type'     => $data['line_item_type'] ?? null,
                'item_type'          => $data['item_type'] ?? null,
                'hsn_or_sac'         => $data['hsn_or_sac'] ?? null,
                'is_invoiced'        => $data['is_invoiced'] ?? 0,
                'quantity_invoiced'     => $data['quantity_invoiced'] ?? null,
                'quantity_backordered'   => $data['quantity_backordered'] ?? null,
                'quantity_cancelled' => $data['quantity_cancelled'] ?? null,
            ]
        );

        // 💰 Sync Taxes
        if (!empty($data['line_item_taxes'])) {
            foreach ($data['line_item_taxes'] as $tax) {
                SalesOrderItemTax::upsertFromZoho($tax, $data['item_id'], $salesOrderId);
            }
        }

        return $item;
    }
}
