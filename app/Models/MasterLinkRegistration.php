<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientCompanyInvitation;
use App\Models\ClientCompany;

class MasterLinkRegistration extends Model
{
    use HasFactory;

    protected $table = 'master_link_registrations';

    protected $fillable = [
        'client_company_id',
        'invitation_id',
        'gstn',
    ];

    /**
     * Relationship: belongs to client_company_invitations
     */
    public function invitation()
    {
        return $this->belongsTo(ClientCompanyInvitation::class, 'invitation_id');
    }

    public function client()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id');
    }
}
