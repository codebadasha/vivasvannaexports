<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestorClient extends Model
{
    protected $table = 'investor_clients';

    protected $fillable = [
        'investor_id',
        'client_company_id'
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function client()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id');
    }

}
