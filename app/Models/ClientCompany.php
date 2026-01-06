<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClientCompany extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $hidden = ['password'];

    protected $fillable = [
        'uuid',
        'zoho_contact_id',
        'company_name',
        'address',
        'state_id',
        'director_name',
        'mobile_number',
        'email',
        'password',
        'gstn',
        'cin',
        'pan_number',
        'credit_amount',
        'interest_rate',
        'tolerance',
        'turnover',
        'msme_register',
        'cin_verify',
        'otp',
        'is_auto_password',
        'is_verify',
        'is_active',
        'is_delete',
        'created_at',
        'updated_at',
    ];

    public function authorized()
    {
        return $this->hasMany(ClientCompanyAuthorizedPerson::class, 'client_company_id', 'id');
    }

    public function contact()
    {
        return $this->hasMany(ClientCompanyContact::class, 'client_company_id', 'id');
    }

    public function investor()
    {
        return $this->hasMany(ClientInvestor::class, 'client_id', 'id');
    }

    public function gstDetails()
    {
        return $this->hasOne(ClientGstDetail::class, 'client_company_id');
    }

    public function getPromoters()
    {
        return $this->hasOne(ClientGstDetail::class, 'client_company_id')
            ->select('client_company_id', 'promoters');
    }

    /**
     * Upsert full customer (company, addresses, authorized person, GST, team member) from Zoho payload.
     */
    public static function upsertFromZoho(array $customerDetails, array $surepassData, int $msmeRegister = 0): self
    {
        return DB::transaction(function () use ($customerDetails, $surepassData, $msmeRegister) {

            $uuid = (string) Str::uuid();

            $email = $customerDetails['email'] ?? $surepassData['email'] ?? null;
            $mobile = $customerDetails['phone'] ?? $customerDetails['mobile'] ?? $surepassData['mobile_number'] ?? null;
            $panNumber = strtoupper($surepassData['pan_number'] ?? null);
            $gstn = strtoupper($surepassData['gstn'] ?? null);

            $companyData = [
                'uuid' => $uuid,
                'zoho_contact_id' => $customerDetails['contact_id'] ?? null,
                'company_name' => $surepassData['company_name'] ?? null,
                'address' => $surepassData['address'] ?? null,
                'state_id' => $surepassData['state_id'] ?? null,
                'director_name' => $surepassData['director_name'][0] ?? null,
                'mobile_number' => $mobile,
                'email' => $email,
                'password' => bcrypt($gstn),
                'gstn' => $gstn,
                'pan_number' => $panNumber,
                'cin' => $surepassData['cin'] ?? null,
                'cin_verify' => $surepassData['cin'] ? 1 : 0,
                'msme_register' => $msmeRegister,
                'turnover' => 0,
                'is_auto_password' => 1,
                'is_verify' => 1,
                'is_active' => 1,
            ];

            // ✅ Find existing company by GSTN or Zoho contact ID
            $company = self::where('gstn', $gstn)
                ->orWhere('zoho_contact_id', $customerDetails['contact_id'] ?? null)
                ->first();

            if ($company) {
                $company->update($companyData);
                Log::info("Updated existing customer company", ['id' => $company->id, 'gstn' => $gstn]);
            } else {
                $company = self::create($companyData);
                Log::info("Created new customer company", ['id' => $company->id, 'gstn' => $gstn]);
            }

            // ✅ Assign default team member
            $teamMember = \App\Models\Admin::where('is_default', 1)
                ->orWhere('role_id', 4)
                ->first();

            if ($teamMember) {
                $company->teamMembers()->updateOrCreate(
                    ['admin_id' => $teamMember->id],
                    ['client_company_id' => $company->id]
                );
            }

            // ✅ Link GST details
            $companyGst = \App\Models\ClientGstDetail::where('gstn', $gstn)->first();
            if ($companyGst) {
                $companyGst->update(['client_company_id' => $company->id]);
            }

            // ✅ Sync authorized person
            if (!empty($surepassData['director_name'][0])) {
                $company->authorized()->delete();
                $company->authorized()->create([
                    'name' => $surepassData['director_name'][0],
                    'email' => $email,
                    'mobile' => $mobile,
                ]);
            }

            // ✅ Sync addresses
            foreach (['billing_address', 'shipping_address'] as $type) {
                if (empty($customerDetails[$type])) {
                    continue;
                }

                $addressType = str_replace('_address', '', $type);
                $addressData = [
                    'address_id' => $customerDetails[$type]['address_id'] ?? null,
                    'attention' => $customerDetails[$type]['attention'] ?? null,
                    'address' => $customerDetails[$type]['address'] ?? null,
                    'street2' => $customerDetails[$type]['street2'] ?? null,
                    'city' => $customerDetails[$type]['city'] ?? null,
                    'state' => $customerDetails[$type]['state'] ?? null,
                    'state_code' => $customerDetails[$type]['state_code'] ?? null,
                    'zip' => $customerDetails[$type]['zip'] ?? null,
                    'country' => $customerDetails[$type]['country'] ?? null,
                    'phone' => $customerDetails[$type]['phone'] ?? null,
                    'fax' => $customerDetails[$type]['fax'] ?? null,
                ];

                $address = $company->addresses()->where('type', $addressType)->first();
                if ($address) {
                    $address->update($addressData);
                } else {
                    $company->addresses()->create(array_merge(['type' => $addressType], $addressData));
                }
            }

            return $company;
        });
    }

    public function addresses()
    {
        return $this->hasMany(ClientCompanyAddress::class, 'client_company_id', 'id');
    }

    public function teamMembers()
    {
        return $this->hasMany(CompanyTeamMember::class, 'client_company_id', 'id');
    }
}
