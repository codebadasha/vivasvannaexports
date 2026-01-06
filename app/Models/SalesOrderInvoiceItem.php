<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalesOrderInvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'sales_order_invoice_items';

    protected $fillable = [
        'invoice_id',
        'line_item_id',
        'item_id',
        'item_order',
        'product_type',
        'name',
        'description',
        'unit',
        'quantity',
        'discount_amount',
        'discount',
        'bcy_rate',
        'rate',
        'tax_id',
        'tax_name',
        'tax_type',
        'item_total',
        'pricing_scheme',
        'hsn_or_sac',
    ];

    public function taxes()
    {
        return $this->hasMany(SalesOrderInvoiceItemTax::class, 'item_id');
    }

    public static function upsertFromZoho(array $data, $invoiceId)
    {
       $item = self::updateOrCreate(
            [
                'invoice_id'   => $invoiceId,
                'line_item_id' => $data['line_item_id'],
            ],
            [
                'invoice_id'       => $invoiceId,
                'line_item_id'     => $data['line_item_id'] ?? null,
                'item_id'          => $data['item_id'] ?? null,
                'item_order'       => $data['item_order'] ?? null,
                'product_type'     => $data['product_type'] ?? null,
                'name'             => $data['name'] ?? null,
                'description'      => $data['description'] ?? null,
                'unit'             => $data['unit'] ?? null,
                'quantity'         => $data['quantity'] ?? 0,
                'discount_amount'  => $data['discount_amount'] ?? 0,
                'discount'         => $data['discount'] ?? 0,
                'bcy_rate'         => $data['bcy_rate'] ?? 0,
                'rate'             => $data['rate'] ?? 0,
                'tax_id'           => $data['tax_id'] ?? null,
                'tax_name'         => $data['tax_name'] ?? null,
                'tax_type'         => $data['tax_type'] ?? null,
                'item_total'       => $data['item_total'] ?? 0,
                'pricing_scheme'   => $data['pricing_scheme'] ?? null,
                'hsn_or_sac'       => $data['hsn_or_sac'] ?? null,
            ]
        );

        // Taxes
        if (!empty($data['line_item_taxes'])) {
            foreach ($data['line_item_taxes'] as $tax) {
                SalesOrderInvoiceItemTax::upsertFromZoho($tax, $data['item_id'], $invoiceId);
            }
        }
        return $item;
    }
}
