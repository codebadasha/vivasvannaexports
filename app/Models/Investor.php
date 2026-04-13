<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\InvestorResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;
use App\Models\SalesOrderInvoice;
use App\Models\SalesOrder;

class Investor extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'is_active',
        'is_delete',
    ];

    protected $hidden = [
        'password','remember_token'
    ];

    public function sendPasswordResetNotification($token)
    {
        $notification = new InvestorResetPasswordNotification($token);
        $notification->sendCustomMail($this);
    }
    
    public function salesOrderInvoices()
    {
        return $this->hasMany(SalesOrderInvoice::class, 'investor_id');
    }

    public function salesOrders()
    {
        return $this->belongsToMany(
            SalesOrder::class,
            'investor_salesorders',
            'investor_id',
            'salesorder_id'
        );
    }

    public function clients()
    {
        return $this->belongsToMany(
            ClientCompany::class,
            'investor_clients',
            'investor_id',
            'client_company_id'
        );
    }
}
