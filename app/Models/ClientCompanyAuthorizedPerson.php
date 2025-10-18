<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCompanyAuthorizedPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_company_id',
        'name',
        'email',
        'mobile',
    ];
}
