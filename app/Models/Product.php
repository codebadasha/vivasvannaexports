<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function variation(){
        return $this->hasMany('App\Models\ProductVariation','product_id','id');
    }
}
