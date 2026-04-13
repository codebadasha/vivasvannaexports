<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditRequestBankStatementReport extends Model
{
    protected $fillable = [
        'credit_request_id',
        'request_amount',
        'bank_id',
        'upload_filepath',
        'txn_id',
        'perfiosTransactionId',
        'perfiosFileId',
        'accountId',
        'accountNumber',
        'accountType',
        'payload',
        'report_file_path',
        'status',
        'reason'
    ];

    protected $casts = [
        'payload' => 'array'
    ];

    public function creditRequest()
    {
        return $this->belongsTo(CreditRequest::class);
    }
    
    public function bank()
    {
        return $this->belongsTo(bank::class, 'bank_id', 'perfios_institution_id');
    }
}