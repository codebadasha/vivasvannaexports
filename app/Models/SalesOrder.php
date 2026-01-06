<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'salesorder_id',
        'salesorder_number',
        'customer_id',
        'project_id',
        'date',
        'status',
        'shipment_date',
        'reference_number',
        'customer_name',
        'place_of_supply',
        'tax_specification',
        'is_taxable',
        'email',
        'currency_id',
        'currency_code',
        'currency_symbol',
        'is_discount_before_tax',
        'delivery_method',
        'delivery_method_id',
        'order_status',
        'shipped_status',
        'invoiced_status',
        'paid_status',
        'created_by_email',
        'created_by_name',
        'branch_id',
        'location_id',
        'location_name',
        'total_quantity',
        'is_emailed',
        'total_invoiced_amount',
        'sub_total',
        'tax_total',
        'discount_total',
        'balance',
        'total',
    ];

    /** 🔗 Relations */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(ClientCompany::class,  'customer_id', 'zoho_contact_id',);
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id');
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class, 'sales_order_id');
    }

    /** 🧠 Upsert from Zoho API */
    public static function upsertFromZoho(array $data)
    {
        $order = self::updateOrCreate(
            ['salesorder_id' => $data['salesorder_id']],
            [
                'salesorder_number'   => $data['salesorder_number'] ?? null,
                'customer_id'         => $data['customer_id'] ?? null,
                'date' => !empty($data['date']) ? $data['date'] : null,
                'shipment_date' => !empty($data['shipment_date']) ? $data['shipment_date'] : null,
                'status'              => $data['status'] ?? null,
                'reference_number'    => $data['reference_number'] ?? null,
                'customer_name'       => $data['customer_name'] ?? null,
                'place_of_supply'     => $data['place_of_supply'] ?? null,
                'tax_specification'   => $data['tax_specification'] ?? null,
                'is_taxable'          => $data['is_taxable'] ?? false,
                'email'               => $data['email'] ?? null,
                'currency_id'         => $data['currency_id'] ?? null,
                'currency_code'       => $data['currency_code'] ?? null,
                'currency_symbol'     => $data['currency_symbol'] ?? null,
                'is_discount_before_tax' => $data['is_discount_before_tax'] ?? false,
                'delivery_method'     => $data['delivery_method'] ?? null,
                'delivery_method_id'  => !empty($data['delivery_method_id']) ? $data['delivery_method_id'] : null,
                'order_status'        => $data['order_status'] ?? null,
                'shipped_status'      => $data['shipped_status'] ?? null,
                'invoiced_status'     => $data['invoiced_status'] ?? null,
                'paid_status'         => $data['paid_status'] ?? null,
                'created_by_email'    => $data['created_by_email'] ?? null,
                'created_by_name'     => $data['created_by_name'] ?? null,
                'branch_id'           => $data['branch_id'] ?? null,
                'location_id'         => $data['location_id'] ?? null,
                'location_name'       => $data['location_name'] ?? null,
                'total_quantity'      => $data['total_quantity'] ?? 0,
                'is_emailed'          => $data['is_emailed'] ?? 0,
                'sub_total'           => $data['sub_total'] ?? 0,
                'total_invoiced_amount'  => $data['total_invoiced_amount'] ?? 0,
                'tax_total'           => $data['tax_total'] ?? 0,
                'discount_total'      => $data['discount_total'] ?? 0,
                'balance'             => $data['balance'] ?? 0,
                'total'             => $data['total'] ?? 0,
            ]
        );

        // 💼 Sync Line Items
        if (!empty($data['line_items'])) {
            foreach ($data['line_items'] as $line) {
                SalesOrderItem::upsertFromZoho($line, $data['salesorder_id']);
            }
        }

        return $order;
    }
}
