<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemQty extends Model
{
    use HasFactory;

    public function supplier(){
        return $this->hasOne('App\Models\SupplierCompany','id','supplier_id');
    }
}
