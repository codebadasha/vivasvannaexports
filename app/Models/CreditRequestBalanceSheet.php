<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditRequestBalanceSheet extends Model
{
    protected $fillable = [
        'credit_request_id',
        'year',
        'filepath'
    ];

    public function creditRequest()
    {
        return $this->belongsTo(CreditRequest::class);
    }
}