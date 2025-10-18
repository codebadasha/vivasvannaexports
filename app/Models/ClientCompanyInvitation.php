<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClientCompanyInvitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'token',
        'gstn',
        'status',
        'is_registered',
        'url',
        'is_master',
        'created_by',
    ];

    protected $casts = [
        'is_registered' => 'boolean',
    ];

    public function registrations()
    {
        return $this->hasMany(MasterLinkRegistration::class, 'invitation_id');
    }
}
