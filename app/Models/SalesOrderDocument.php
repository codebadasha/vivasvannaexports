<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderDocument extends Model
{
    protected $fillable = [
        'sales_order_id',
        'document_id',
        'file_name',
        'file_type',
        'attachment_order'
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }
}
