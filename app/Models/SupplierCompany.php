<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCompany extends Model
{
    use HasFactory;

    public function authorized(){
        return $this->hasMany('App\Models\AuthorizedPerson','supplier_company_id','id');
    }

    public function product(){
        return $this->hasMany('App\Models\SupplierProduct','supplier_company_id','id');
    }
}
