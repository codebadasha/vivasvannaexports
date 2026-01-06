<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderInvoiceItemTax extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_id',
        'tax_id',
        'tax_name',
        'tax_amount',
        'tax_percentage',
        'tax_specific_type',
    ];

    public function item()
    {
        return $this->belongsTo(SalesOrderInvoiceItem::class, 'invoice_item_id');
    }

    public static function upsertFromZoho(array $taxData, $invoiceItemId, $invoiceId)
    {
        return self::updateOrCreate(
            [
                'invoice_id' => $invoiceId,
                'item_id' => $invoiceItemId,
                'tax_id' => $taxData['tax_id'],
            ],
            [
                'tax_id' => $taxData['tax_id'],
                'tax_name' => $taxData['tax_name'] ?? null,
                'tax_amount' => $taxData['tax_amount'] ?? 0,
                'tax_percentage' => $taxData['tax_percentage'] ?? null,
                'tax_specific_type' => $taxData['tax_specific_type'] ?? null,
            ]
        );
    }
}
