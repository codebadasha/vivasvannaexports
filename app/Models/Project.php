<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'zoho_client_id',
        'name',
        'description'
    ];

    

    public function client(){
        return $this->hasOne('App\Models\ClientCompany','id','client_id');
    }

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class, 'project_id');
    }
}
