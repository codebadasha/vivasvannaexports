<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    use HasFactory;

    public function variation(){
        return $this->hasOne('App\Models\ProductVariation','id','product_id');
    }
}
