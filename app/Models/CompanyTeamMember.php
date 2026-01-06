<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'client_company_id'
    ];
}
