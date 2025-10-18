<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGstDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_company_id',
        'gstn',
        'pan',
        'cin',
        'nature_of_business',
        'promoters',
        'annual_turnover',
        'annual_turnover_fy',
        'aadhaar_validation',
        'aadhaar_validation_date',
        'einvoice_status',
        'client_id',
        'business_name',
        'legal_name',
        'center_jurisdiction',
        'state_jurisdiction',
        'date_of_registration',
        'constitution_of_business',
        'taxpayer_type',
        'gstin_status',
        'nature_bus_activities',
    ];

    protected $casts = [
        'promoters' => 'array',
        'nature_bus_activities' => 'array',
        'einvoice_status' => 'boolean',
        'aadhaar_validation_date' => 'date',
        'date_of_registration' => 'date',
    ];

    // Relation to ClientCompany
    public function clientCompany()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id');
    }
}
