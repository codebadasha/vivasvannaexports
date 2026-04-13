<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderInvoiceEwayBill extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'invoice_id',
        'ewaybill_id',

        'entity_id',
        'entity_type',
        'entity_number',
        'entity_date_formatted',
        'entity_status',

        'supplier_gstin',
        'customer_name',
        'customer_gstin',

        'ewaybill_number',
        'ewaybill_date',
        'ewaybill_start_date',
        'ewaybill_expiry_date',

        'ewaybill_status',
        'ewaybill_status_formatted',
        'ewaybill_type',
        'validity_days',

        'sub_supply_type',
        'distance',

        'transporter_id',
        'transporter_name',
        'transporter_license',
        'transporter_registration_id',

        'place_of_dispatch',
        'place_of_delivery',
        'ship_to_state_code',
        'entity_total',
        'vehicle_details'
    ];

    protected $casts = [
        'ewaybill_date' => 'datetime',
        'ewaybill_start_date' => 'datetime',
        'ewaybill_expiry_date' => 'datetime',
        'transporter_document_date' => 'date',
        'entity_total' => 'decimal:2',
        'can_allow_print_ewaybill' => 'boolean',
        'can_allow_cancel_ewaybill' => 'boolean',
        'vehicle_details' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(SalesOrderInvoice::class, 'invoice_id');
    }
}
