<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditRequest extends Model
{
    use HasFactory;

    public function sheet(){
        return $this->hasMany('App\Models\CreditFinancialData','credit_request_id','id');
    }
    public function statement(){
        return $this->hasMany('App\Models\CreditData','credit_request_id','id');
    }
    public function client(){
        return $this->hasOne('App\Models\ClientCompany','id','client_id');
    }
    
}
