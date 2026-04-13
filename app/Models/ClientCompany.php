<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ClientResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Services\ZohoBookService;

class ClientCompany extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $hidden = ['password','remember_token'];

    protected $fillable = [
        'uuid',
        'admin_id',
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

    public function sendPasswordResetNotification($token)
    {
        $notification = new ClientResetPasswordNotification($token);
        $notification->sendCustomMail($this);
    }

    public function authorized()
    {
        return $this->hasMany(ClientCompanyAuthorizedPerson::class, 'client_company_id', 'id');
    }

    public function contact()
    {
        return $this->hasMany(ClientCompanyContact::class);
    }

    public function investor()
    {
        return $this->hasMany(ClientInvestor::class, 'client_id', 'id');
    }

    public function gstDetails()
    {
        return $this->hasOne(ClientGstDetail::class);
    }

    public function getPromoters()
    {
        return $this->hasOne(ClientGstDetail::class, 'client_company_id')
            ->select('client_company_id', 'promoters');
    }
    
    public function investors()
    {
        return $this->belongsToMany(
            Investor::class,
            'investor_clients',
            'client_company_id',
            'investor_id'
        );
    }
    /**
     * Upsert full customer (company, addresses, authorized person, GST, team member) from Zoho payload.
     */
    public static function upsertFromZoho(array $customerDetails, array $surepassData, int $msmeRegister = 0): self
    {
        return DB::transaction(function () use ($customerDetails, $surepassData, $msmeRegister) {

            $gstn = strtoupper($surepassData['gstn'] ?? null);

            $company = self::where('gstn', $gstn)
                ->orWhere('zoho_contact_id', $customerDetails['contact_id'] ?? null)
                ->first();

            $companyGst = \App\Models\ClientGstDetail::where('gstn', $gstn)->first();
            $constitution = $companyGst?->constitution_of_business ?? '';

            $uuid = (string) Str::uuid();
            $firstName = $customerData['first_name'] ?? '';
            $lastName  = $customerData['last_name'] ?? '';
            $name      = trim($firstName . ' ' . $lastName);
            $email     = $customerData['email'] ?? null;
            $normalizedMobile = $existingCompany->normalizeMobile($customerData['mobile'] ?? null);
            $panNumber = strtoupper($surepassData['pan_number'] ?? null);

            $companyData = [
                'uuid' => $uuid,
                'zoho_contact_id' => $customerDetails['contact_id'] ?? null,
                'company_name' => $surepassData['company_name'] ??  null,
                'address' => $surepassData['address'] ?? null,
                'state_id' => $surepassData['state_id'] ?? null,
                'director_name' => $name,
                'mobile_number' => $mobile ?? '',
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

            if ($company) {
                $company->update($companyData);
                Log::info("Updated existing customer company", ['id' => $company->id, 'gstn' => $gstn]);
            } else {
                $company = self::create($companyData);
                Log::info("Created new customer company", ['id' => $company->id, 'gstn' => $gstn]);
            }

            // Prepare contact data
            $contactData = [
                'company'           => $company,
                'zoho_contacts'     => $customerDetails['contact_persons'] ?? [],
                'surepass_contacts' => [],
                'zoho_contact_id'   => $customerDetails['contact_id'] ?? null,   // Parent contact ID in Zoho
            ];

            // Add Surepass Director as Contact Person for Proprietorship & Partnership
            if (in_array($constitution, ['Proprietorship', 'Partnership']) && !empty($surepassData['mobile_number'])) {
                $normalizedMobile = $company->normalizeMobile($surepassData['mobile_number']);

                if (!empty($normalizedMobile)) {
                    $contactData['surepass_contacts'][] = [
                        'contact_person_id' => null,
                        'name'              => $surepassData['director_name'][0] ?? null,
                        'email'             => $email,
                        'mobile'            => $normalizedMobile,
                        'phone'             => null,
                        'designation'       => null,
                        'is_primary'        => false,
                    ];
                }
            }
            
            if ((!empty($contactData['zoho_contacts']) && is_array($contactData['zoho_contacts'])) ||
            (!empty($contactData['surepass_contacts']) && is_array($contactData['surepass_contacts']))) 
            {
                Log::info("start new customer company contacts create type", ['id' => $company->id, 'gstn' => $gstn, 'type' => $constitution]);
                self::contactPersonsUpsert($contactData);                
            }
            
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

    public static function contactPersonsUpsert(array $contactData): void
    {
        $company          = $contactData['company'];
        $zohoContacts     = $contactData['zoho_contacts'];
        $surepassContacts = $contactData['surepass_contacts'];
        $zohoContactId    = $contactData['zoho_contact_id'];
        $processedMobiles = [];

        if (!empty($zohoContacts) && is_array($zohoContacts)) {
            foreach ($zohoContacts as $person) {
                $firstName = $person['first_name'] ?? '';
                $lastName  = $person['last_name'] ?? '';
                $name      = trim($firstName . ' ' . $lastName);

                $email         = $person['email'] ?? null;
                $mobileRaw     = $person['mobile'] ?? null;
                $phoneRaw      = $person['phone'] ?? null;
                $designation   = $person['designation'] ?? null;
                $isPrimaryZoho = $person['is_primary_contact'] ?? false;
                $contactPersonId = $person['contact_person_id'] ?? null;   // if Zoho sends this

                $normalizedMobile = $company->normalizeMobile($mobileRaw);
                $normalizedPhone  = $company->normalizeMobile($phoneRaw);

                if (empty($normalizedMobile) && empty($normalizedPhone)) {
                    continue;
                }

                $isPrimary = $isPrimaryZoho ? 1 : 0;

                $data = [
                    'contact_person_id' => $contactPersonId,
                    'name'              => !empty($name) ? $name : null,
                    'email'             => !empty($email) ? $email : null,
                    'mobile'            => !empty($normalizedMobile) ? $normalizedMobile : null,
                    'phone'             => !empty($normalizedPhone) ? $normalizedPhone : null,
                    'designation'       => !empty($designation) ? $designation : null,
                    'is_primary'        => $isPrimary,
                ];

                Log::info("new customer company contacts details from zoho contacts", ['gst' => $company->gstn, 'data' => $data]);

                $company->contact()->updateOrCreate(
                    ['contact_person_id' => $contactPersonId],
                    $data
                );

                if(!empty($normalizedMobile) && !in_array($normalizedMobile, $processedMobiles)){
                    $processedMobiles[] = $normalizedMobile;
                }     

                if(!empty($normalizedPhone) && !in_array($normalizedPhone, $processedMobiles)){
                    $processedMobiles[] = $normalizedPhone;
                }     
            }
        }
        Log::info("start new customer company total contacts after zoho contacts", ['total' => $processedMobiles]);

        if (!empty($surepassContacts) && is_array($surepassContacts)) {
            foreach ($surepassContacts as $contact) {
                if (in_array($contact['mobile'], $processedMobiles)) {
                    continue; // Already added from Zoho
                }
                
                if ($zohoContactId) 
                {
                    $zohoService = new ZohoBookService();
                    $zohoPayload = [
                        'contact_id'        => $zohoContactId,
                        'first_name'        => $contact['name'],
                        'email'             => $contact['email'],
                        'mobile'            => $contact['mobile']
                    ];

                    try {
                        $zohoResponse = $zohoService->CreateCustomerContact($zohoPayload);
                        $contact['contact_person_id'] = $zohoResponse['contact_person']['contact_person_id'] ?? null;

                        Log::info('Zoho Contact Person Created', [
                            'company_id' => $company->id,
                            'zoho_contact_person_id' => $contact['contact_person_id']
                        ]);

                    } catch (\Exception $e) {
                        Log::error('Failed to create contact person in Zoho', [
                            'company_id' => $company->id,
                            'error' => $e->getMessage()
                        ]);
                        // Still save locally even if Zoho fails
                    }
                }

                $localPayload = [
                    'contact_person_id' => $contact['contact_person_id'],
                    'name'              => $contact['name'] ?? null,
                    'email'             => $contact['email'] ?? null,
                    'mobile'            => $contact['mobile'],
                    'phone'             => $contact['phone'] ?? null,
                    'is_primary'        => $contact['is_primary'] ?? 1,
                ];

                Log::info("new customer company contacts details from zoho contacts", ['gst' => $company->gstn, 'data' => $localPayload]);

                $company->contact()->updateOrCreate(
                    ['mobile' => $contact['mobile']],     // Use mobile as the unique matching key
                    $localPayload
                );

                $processedMobiles[] = $contact['mobile'];

            }
        }

        Log::info("start new customer company total contacts after sure pass contacts", ['total' => $processedMobiles]);
    }

    public function normalizeMobile($mobile)
    {
        if (empty($mobile)) {
            return null;
        }

        $mobile = trim((string)$mobile);

        // === Your requested logic: Check for '-' and explode ===
        if (strpos($mobile, '-') !== false) {
            $parts = explode('-', $mobile);
            $mobile = end($parts);        // Take the last part after last '-'
        }

        // Now clean the number (remove all non-digits)
        $mobile = preg_replace('/\D+/', '', $mobile);

        // Remove leading '0' or '91' if number is longer than 10 digits
        if (strlen($mobile) > 10) {
            if (str_starts_with($mobile, '91')) {
                $mobile = substr($mobile, 2);
            } elseif (str_starts_with($mobile, '0')) {
                $mobile = substr($mobile, 1);
            }
        }

        // Return only last 10 digits
        return substr($mobile, -10) ?: null;
    }

    // private function addOrUpdateAuthorized($company, $name, $email, $normalizedMobile)
    // {
    //     $existing = $company->authorized()->where('mobile', $normalizedMobile)->first();

    //     if ($existing) {
    //         $existing->update([
    //             'name'  => $name,
    //             'email' => $email,
    //             'mobile'=> $normalizedMobile,
    //         ]);
    //     } else {

    //         $company->authorized()->create([
    //             'name'  => $name,
    //             'email' => $email,
    //             'mobile'=> $normalizedMobile,
    //         ]);
    //     }
    // }

    public function addresses()
    {
        return $this->hasMany(ClientCompanyAddress::class, 'client_company_id', 'id');
    }

    public function teamMembers()
    {
        return $this->hasMany(CompanyTeamMember::class, 'client_company_id', 'id');
    }
}
