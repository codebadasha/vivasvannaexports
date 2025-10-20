<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ClientCompany extends Authenticatable
{
    use HasFactory;

    protected $hidden = [
        'password'
    ];

    protected $fillable = [
        'uuid',
        'zoho_contact_id',
        'company_name',
        'address',
        'state_id',
        'director_name',
        'mobile_number',
        'email',
        'password',
        'gstn',
        'cin',
        'pan_number',
        'credit_amount',
        'interest_rate',
        'tolerance',
        'turnover',
        'msme_register',
        'cin_verify',
        'otp',
        'is_auto_password',
        'is_verify',
        'is_active',
        'is_delete',
        'created_at',
        'updated_at',
    ];

    public function authorized()
    {
        return $this->hasMany('App\Models\ClientCompanyAuthorizedPerson', 'client_company_id', 'id');
    }
    public function contact()
    {
        return $this->hasMany('App\Models\ClientCompanyContact', 'client_company_id', 'id');
    }
    public function investor()
    {
        return $this->hasMany('App\Models\ClientInvestor', 'client_id', 'id');
    }

    public function getGstDetails()
    {
        return $this->hasOne(ClientGstDetail::class, 'client_company_id');
    }

    public function getpromoters()
    {
        return $this->hasOne(ClientGstDetail::class, 'client_company_id')
            ->select('client_company_id', 'promoters');
    }
}
