<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestorSalesOrder extends Model
{
    protected $table = 'investor_salesorders';

    protected $fillable = [
        'investor_id',
        'salesorder_id'
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'salesorder_id');
    }

}
