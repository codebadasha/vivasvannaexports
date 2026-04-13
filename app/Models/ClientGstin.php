<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientGstin extends Model
{
    protected $table = 'client_gstins';

    protected $fillable = [
        'client_company_id',
        'gstin',
        'pan_number',
        'auth_status',
        'application_status',
        'email_id',
        'gstin_ref_id', 
        'mob_num',
        'reg_type',
        'registration_name',
        'tin_number',
        'state'
    ];

    public function company()
    {
        return $this->belongsTo(ClientCompany::class);
    }
}