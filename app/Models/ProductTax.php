<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ProductTax extends Model
{
    protected $table = 'product_taxes';

    protected $fillable = [
        'tax_id',
        'tax_name',
        'tax_name_formatted',
        'tax_percentage',
        'tax_type',
        'tax_account_id',
        'output_tax_account_name',
        'tds_payable_account_id',
        'tax_specific_type',
        'is_state_cess',
        'is_inactive',
        'is_default_tax',
        'is_editable',
        'tax_specification',
        'diff_rate_reason',
        'start_date',
        'end_date',
        'status',
        'description',
        'last_modified_time',
        'raw',
    ];

    protected $casts = [
        'is_state_cess' => 'boolean',
        'is_inactive' => 'boolean',
        'is_default_tax' => 'boolean',
        'is_editable' => 'boolean',
        'tax_percentage' => 'float',
        'last_modified_time' => 'datetime',
        'raw' => 'array'
    ];

    /**
     * Upsert a model from a full Zoho tax/tax group API response
     * Accepts either the raw array or nested 'tax' key depending on response.
     */
    public static function upsertFromZoho(array $zohoPayload)
    {
        // Sometimes Zoho returns ['tax' => [...]] or returns the tax directly
        $tax = $zohoPayload['tax'] ?? $zohoPayload;
        Log::error("tax API call for store", $tax);

        $taxId = $tax['tax_id'] ?? null;
       
        if (!$taxId) {
            throw new \Exception('No tax id in tax payload');
        }

        $data = [
            'tax_id' => $taxId,
            'tax_name' => $tax['tax_name'] ?? null,
            'tax_name_formatted' => $tax['tax_name_formatted'] ?? null,
            'tax_percentage' => isset($tax['tax_percentage']) ? (float)$tax['tax_percentage'] : null,
            'tax_type' => $tax['tax_type'] ?? null,
            'tax_account_id' => $tax['tax_account_id'] ?? null,
            'output_tax_account_name' => $tax['output_tax_account_name'] ?? null,
            'tds_payable_account_id' => $tax['tds_payable_account_id'] ?? null,
            'tax_specific_type' => $tax['tax_specific_type'] ?? null,
            'is_state_cess' => isset($tax['is_state_cess']) ? (bool)$tax['is_state_cess'] : false,
            'is_inactive' => isset($tax['is_inactive']) ? (bool)$tax['is_inactive'] : false,
            'is_default_tax' => isset($tax['is_default_tax']) ? (bool)$tax['is_default_tax'] : false,
            'is_editable' => isset($tax['is_editable']) ? (bool)$tax['is_editable'] : true,
            'tax_specification' => $tax['tax_specification'] ?? null,
            'diff_rate_reason' => $tax['diff_rate_reason'] ?? null,
            'start_date' => $tax['start_date'] ?? null,
            'end_date' => $tax['end_date'] ?? null,
            'status' => $tax['status'] ?? null,
            'description' => $tax['description'] ?? null,
            'last_modified_time' => isset($tax['last_modified_time']) ? date('Y-m-d H:i:s', strtotime($tax['last_modified_time'])) : null,
            'raw' => json_encode($tax),
        ];
Log::info("tax API call for store data", [$data]);
        return self::updateOrCreate(
            ['tax_id' => $taxId], // lookup
            $data                    // insert/update
        );
    }
}