<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoqItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'boq_id',
        'product_id',
        'qty',
        'remaining_qty',
        'unit',
    ];

    public function product(){
        return $this->hasOne('App\Models\Product','zoho_item_id','product_id');
    }
    
}
