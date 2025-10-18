<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boq extends Model
{
    use HasFactory;

    public function item(){
        return $this->hasMany('App\Models\BoqItem','boq_id','id');
    }
    public function project(){
        return $this->hasOne('App\Models\Project','id','project_id');
    }
    public function client(){
        return $this->hasOne('App\Models\ClientCompany','id','client_id');
    }
}
