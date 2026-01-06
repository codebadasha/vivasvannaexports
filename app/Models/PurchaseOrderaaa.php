<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    public function project(){
        return $this->hasOne('App\Models\Project','id','project_id');
    }
    public function boq(){
        return $this->hasOne('App\Models\BoqItem','id','boq_id');
    }
    public function client(){
        return $this->hasOne('App\Models\ClientCompany','id','client_id');
    }
    public function item(){
        return $this->hasMany('App\Models\PurchaseOrderItem','po_id','id');
    }
    public function note(){
        return $this->hasMany('App\Models\Ponote','po_id','id');
    }
    
    
}
