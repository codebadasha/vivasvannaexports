<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderInvoiceDocument extends Model
{
    protected $fillable = [
        'invoice_id',
        'document_id',
        'file_name',
        'file_type',
        'attachment_order'
    ];

    public function invoice()
    {
        return $this->belongsTo(SalesOrderInvoice::class, 'invoice_id');
    }
}
