<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'zoho_user_id',
        'zoho_role_id',
        'role_id',
        'invitation_type',
        'is_super_admin',
        'user_role',
        'is_current_user',
        'photo_url',
        'is_customer_segmented',
        'is_vendor_segmented',
        'is_employee',
        'source',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $notification = new AdminResetPasswordNotification($token);
        $notification->sendCustomMail($this);
    }

    public function role(){
        return $this->hasOne('App\Models\Role','id','role_id');
    }


    public static function upsertFromZoho(array $userDetails): self
    {
        return DB::transaction(function () use ($userDetails) {
            
            $userDetails['zoho_user_id'] = $userDetails['user_id'];
            $userDetails['zoho_role_id'] = $userDetails['role_id'];

            unset($userDetails['user_id'], $userDetails['role_id']);

            $userDetails['password'] = Hash::make('admin@123');
            
            // Set auto generate flag
            $userDetails['is_auto_generate'] = 1;

            $zohoUserId = $userDetails['zoho_user_id'];
            $zohoRoleId = $userDetails['zoho_role_id'];

            $role = Role::where('zoho_role_id', $zohoRoleId)->first();

            if (!$role) {
                $role = Role::create([
                    'name' => $userDetails['user_role'] ?? 'Zoho Role',
                    'zoho_role_id' => $zohoRoleId,
                ]);

                Log::info("Created new role from Zoho", [
                    'role_id' => $role->id,
                    'zoho_role_id' => $zohoRoleId
                ]);
            }

            // Assign role_id to admin
            $userDetails['role_id'] = $role->id;

            $user = self::where('zoho_user_id', $zohoUserId)->first();

            if ($user) {
                $user->update($userDetails);
                Log::info("Updated existing update", ['id' => $user->id, 'zoho_user_id' => $zohoUserId]);
            } else {
                $user = self::create($userDetails);
                Log::info("Created new update", ['id' => $user->id, 'zoho_user_id' => $zohoUserId]);
            }

            return $user;
        });
    }

}