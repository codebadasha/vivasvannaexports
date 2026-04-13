<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCompanyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_company_id',
        'contact_person_id',
        'name',
        'email',
        'mobile',
        'phone',
        'is_primary',
        'designation',
    ];

    public function clientCompany()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id');
    }
}
