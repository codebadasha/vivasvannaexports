<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderInvoice extends Model
{
    use HasFactory;

    public function po(){
        return $this->hasOne('App\Models\PurchaseOrder','id','po_id');
    }
    public function investor(){
        return $this->hasOne('App\Models\Investor','id','investor_id');
    }
    public function item(){
        return $this->hasOne('App\Models\PurchaseOrderItem','id','item_id');
    }

}
