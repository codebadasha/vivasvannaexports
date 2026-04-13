<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditRequestGstScoreReport extends Model
{
    protected $fillable = [
        'credit_request_id',
        'refID',
        'prfios_requestId',
        'prfios_stamessage',
        'perfios_excexlfilelink',
        'perfios_pdffilelink',
        'local_excexlfilepath',
        'local_pdffilepath',
        'json_payload',
        'status',
        'reason'
    ];

    protected $casts = [
        'json_payload' => 'array'
    ];

    public function creditRequest()
    {
        return $this->belongsTo(CreditRequest::class);
    }
}