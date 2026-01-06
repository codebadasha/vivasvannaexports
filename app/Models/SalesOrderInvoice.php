<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalesOrderInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'salesorder_id',
        'invoice_number',
        'reference_number',
        'status',
        'date',
        'total',
        'due_date',
        'balance'        
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'salesorder_id', 'salesorder_id');
    }

    public function items()
    {
        return $this->hasMany(SalesOrderInvoiceItem::class, 'invoice_id');
    }

    public function ewaybill()
    {
        return $this->hasOne(SalesOrderInvoiceEwaybill::class, 'invoice_id', 'invoice_id');
    }

    public function investor()
    {
        return $this->hasOne(Investor::class, 'id','investor_id');
    }

    /**
     * Sync or Update invoice from Zoho response
     */
    public static function upsertFromZoho(array $data, $salesOrderId = null)
    {
        DB::transaction(function () use ($data, $salesOrderId) {
            // dd($data['invoice_id']);
            $invoice = self::updateOrCreate(
                ['invoice_id' => $data['invoice_id']],
                [
                    'salesorder_id' => $salesOrderId,
                    'invoice_number' => $data['invoice_number'] ?? null,
                    'status' => $data['status'] ?? null,
                    'reference_number' => $data['reference_number'] ?? null,
                    'due_date' => $data['due_date'] ?? null,
                    'date' => $data['date'] ?? null,
                    'total' => $data['total'] ?? 0,
                    'balance' => $data['balance'] ?? 0
                ]
            );

            // Sync items
            if (!empty($data['line_items'])) {
                foreach ($data['line_items'] as $lineItem) {
                    SalesOrderInvoiceItem::upsertFromZoho($lineItem, $data['invoice_id']);
                }
            }

        
            // Sync E-way bill
            if (!empty($data['ewaybills'])) {
                foreach ($data['ewaybills'] as $ewaybill) {
                    SalesOrderInvoiceEwaybill::upsertFromZoho($ewaybill, $data['invoice_id']);
                }
            }
        });
    }
}
