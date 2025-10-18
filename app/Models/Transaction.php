<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function client(){
        return $this->hasOne('App\Models\ClientCompany','id','client_id');
    }
    public function project(){
        return $this->hasOne('App\Models\Project','id','project_id');
    }
    public function po(){
        return $this->hasOne('App\Models\PurchaseOrder','id','po_id');
    }
}
