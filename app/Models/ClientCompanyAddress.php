<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCompanyAddress extends Model
{
    use HasFactory;

    protected $table = 'client_company_addresses';

    protected $fillable = [
        'client_company_id',
        'address_id',
        'type',              // 'billing' or 'shipping'
        'attention',
        'address',
        'street2',
        'city',
        'state',
        'state_code',
        'zip',
        'country',
        'phone',
        'fax',
    ];

    /**
     * 🔗 Relationship: Address belongs to a ClientCompany
     */
    public function company()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id');
    }

    /**
     * 🔍 Scope: Get only billing addresses
     */
    public function scopeBilling($query)
    {
        return $query->where('type', 'billing');
    }

    /**
     * 🔍 Scope: Get only shipping addresses
     */
    public function scopeShipping($query)
    {
        return $query->where('type', 'shipping');
    }
}
