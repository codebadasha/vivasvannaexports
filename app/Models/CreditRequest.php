<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditRequest extends Model
{
    protected $fillable = [
        'client_company_id',
        'credit_amount',
        'interest_rate',
        'tolerance',
        'request_step',
        'status',
        'reason'
    ];

    public function client()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id');
    }

    public function bankReport()
    {
        return $this->hasOne(CreditRequestBankStatementReport::class);
    }

    public function gstReport()
    {
        return $this->hasOne(CreditRequestGstScoreReport::class);
    }

    public function balanceSheets()
    {
        return $this->hasMany(CreditRequestBalanceSheet::class);
    }
}