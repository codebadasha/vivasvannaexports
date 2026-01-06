<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCompanyAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_company_id',
        'type',
        'attention',
        'address',
        'street2',
        'city',
        'state',
        'state_code',
        'country',
        'country_code',
        'zip',
        'phone',
        'fax',
    ];

    public function company()
    {
        return $this->belongsTo(SupplierCompany::class, 'supplier_company_id');
    }
}
