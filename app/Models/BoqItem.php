<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqItem extends Model
{
    use HasFactory;

    public function category(){
        return $this->hasOne('App\Models\Product','id','category_id');
    }
    public function grade(){
        return $this->hasOne('App\Models\ProductVariation','id','variation_id');
    }
}
