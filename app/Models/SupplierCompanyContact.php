<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCompanyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_company_id',
        'first_name',
        'last_name',
        'email',
        'mobile',
        'phone',
        'designation',
        'is_primary_contact',
    ];

    public function company()
    {
        return $this->belongsTo(SupplierCompany::class, 'supplier_company_id');
    }
}
