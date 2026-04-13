<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDocument extends Model
{
    protected $fillable = [
        'purchase_orders_id',
        'document_id',
        'file_name',
        'file_type',
        'attachment_order'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
