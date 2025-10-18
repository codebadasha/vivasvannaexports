<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    public function varation(){
        return $this->hasOne('App\Models\ProductVariation','id','category_id');
    }
    public function item(){
        return $this->hasMany('App\Models\ItemQty','po_item_id','id');
    }
    public function po(){
        return $this->hasOne('App\Models\PurchaseOrder','id','po_id');
    }
}
