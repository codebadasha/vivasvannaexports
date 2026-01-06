<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderInvoiceEwaybill extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'ewaybill_id',
        'ewaybill_number',
        'ewaybill_status',
        'ewaybill_status_formatted',
        'ewaybill_date',
        'ewaybill_expiry_date',
        'sub_supply_type',
        'transportation_mode',
        'transporter_id',
        'transporter_name',
        'transporter_registration_id',
    ];

    public static function upsertFromZoho(array $data, $invoiceId)
    {
        self::updateOrCreate(
            ['ewaybill_id' => $data['ewaybill_id'], 'invoice_id' => $invoiceId,],
            [
                'invoice_id' => $invoiceId,
                'ewaybill_number' => $data['ewaybill_number'] ?? null,
                'ewaybill_status' => $data['ewaybill_status'] ?? null,
                'ewaybill_status_formatted' => $data['ewaybill_status_formatted'] ?? null,
                'ewaybill_date' => !empty($data['ewaybill_date']) ? $data['ewaybill_date'] : null,
                'ewaybill_expiry_date' => !empty($data['ewaybill_expiry_date']) ? $data['ewaybill_expiry_date'] : null,
                'sub_supply_type' => $data['sub_supply_type'] ?? null,
                'transportation_mode' => $data['transportation_mode'] ?? null,
                'transporter_id' => $data['transporter_id'] ?? null,
                'transporter_name' => $data['transporter_name'] ?? null,
                'transporter_registration_id' => $data['transporter_registration_id'] ?? null,
            ]
        );
    }
}
