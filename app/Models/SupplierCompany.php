<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SupplierCompany extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'zoho_contact_id',
        'company_logo',
        'company_name',
        'address',
        'state_id',
        'mobile',
        'email',
        'gstn',
        'iec_code',
        'pancard',
        'is_active',
        'is_delete',
        'gstn_image',
        'iec_code_image',
        'pancard_image',
    ];

    public function addresses()
    {
        return $this->hasMany(SupplierCompanyAddress::class);
    }

    public function contacts()
    {
        return $this->hasMany(SupplierCompanyContact::class);
    }

    public function authorized()
    {
        return $this->hasMany('App\Models\AuthorizedPerson', 'supplier_company_id', 'id');
    }

    public function product()
    {
        return $this->hasMany('App\Models\SupplierProduct', 'supplier_company_id', 'id');
    }

    public static function upsertFromZoho(array $vendorDetails): self
    {
        return DB::transaction(function () use ($vendorDetails) {

            $stateId = 0;
            if (!empty($vendorDetails['billing_address']['state'])) {
                $state = State::select('id')
                    ->where('name', $vendorDetails['billing_address']['state'])
                    ->first();
                $stateId = $state ? $state->id : 0;
            }

            $uuid = (string) Str::uuid();

            $companyData = [
                'uuid' => $uuid,
                'zoho_contact_id' => $vendorDetails['contact_id'] ?? null,
                'company_name' => $vendorDetails['contact_name'] ?? null,
                'state_id' => $stateId,
                'mobile' => $vendorDetails['mobile'] ?? null,
                'email' => $vendorDetails['email'] ?? null,
                'gstn' => strtoupper($vendorDetails['gst_no'] ?? ''),
                'pancard' => $vendorDetails['pan_no'] ?? null,
                'iec_code' => $vendorDetails['pan_no'] ?? null,
            ];

            // ✅ Try to find existing company
            $company = self::where('gstn', strtoupper($vendorDetails['gst_no'] ?? ''))
                ->Where('zoho_contact_id', $vendorDetails['contact_id'] ?? null)
                ->first();

            if ($company) {
                $company->update($companyData);
                Log::info("Updated existing supplier company", ['id' => $company->id, 'gstn' => $company->gstn]);
            } else {
                $company = self::create($companyData);
                Log::info("Created new supplier company", ['id' => $company->id, 'gstn' => $company->gstn]);
            }

            // ✅ Sync Addresses
            foreach (['billing_address', 'shipping_address'] as $type) {
                if (empty($vendorDetails[$type])) {
                    continue;
                }

                $addressType = str_replace('_address', '', $type);
                $addressData = [
                    'address_id'  => $vendorDetails[$type]['address_id'] ?? null,
                    'attention'  => $vendorDetails[$type]['attention'] ?? null,
                    'address'    => $vendorDetails[$type]['address'] ?? null,
                    'street2'    => $vendorDetails[$type]['street2'] ?? null,
                    'city'       => $vendorDetails[$type]['city'] ?? null,
                    'state'      => $vendorDetails[$type]['state'] ?? null,
                    'state_code' => $vendorDetails[$type]['state_code'] ?? null,
                    'zip'        => $vendorDetails[$type]['zip'] ?? null,
                    'country'    => $vendorDetails[$type]['country'] ?? null,
                    'phone'      => $vendorDetails[$type]['phone'] ?? null,
                    'fax'        => $vendorDetails[$type]['fax'] ?? null,
                ];

                $address = $company->addresses()
                    ->where('type', $addressType)
                    ->first();

                if ($address) {
                    $address->update($addressData);
                    Log::info("Updated {$addressType} address", ['company_id' => $company->id]);
                } else {
                    $company->addresses()->create(array_merge(['type' => $addressType], $addressData));
                    Log::info("Created {$addressType} address", ['company_id' => $company->id]);
                }
            }

            // ✅ Sync Contacts
            if (!empty($vendorDetails['contact_persons'])) {
                $company->contacts()->delete();
                foreach ($vendorDetails['contact_persons'] as $person) {
                    $company->contacts()->create([
                        'first_name' => $person['first_name'] ?? null,
                        'last_name' => $person['last_name'] ?? null,
                        'mobile' => $person['mobile'] ?? null,
                        'email' => $person['email'] ?? null,
                        'phone' => $person['phone'] ?? null,
                        'designation' => $person['designation'] ?? null,
                        'is_primary_contact' => $person['is_primary_contact'] ?? false,
                    ]);
                }
                Log::info("Refreshed contact persons", ['company_id' => $company->id,"gst"=>$vendorDetails['gst_no']]);
                
            }

            return $company;
        });
    }
}
