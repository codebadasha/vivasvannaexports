<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterLinkRegistration extends Model
{
    use HasFactory;

    protected $table = 'master_link_registrations';

    protected $fillable = [
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
}
