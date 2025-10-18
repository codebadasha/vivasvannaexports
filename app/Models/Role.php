<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function module(){
        return $this->hasMany('App\Models\RoleModule','role_id','id');
    }

    public function element(){
        return $this->hasMany('App\Models\RoleElement','role_id','id');
    }
}
