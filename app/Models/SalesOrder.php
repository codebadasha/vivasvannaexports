<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SalesOrderDocument;
use App\Models\Project;
use App\Models\Investor;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'zoho_salesorder_id',
        'salesorder_number',
        'date',
        'customer_id',
        'customer_name',
        'company_name',
        'reference_number',
        'project_id',
        'current_sub_status',
        'order_status',
        'invoiced_status',
        'paid_status',
        'shipped_status',
        'delivery_method',
        'delivery_method_id',
        'shipment_date',
        'total',
        'total_quantity',
        'total_invoiced_amount',
        'quantity_invoiced',
        'sub_total',
        'discount_total',
        'tax_total',
        'balance',
        'created_by_email',
        'created_by_name',
        'created_by_id',
        'zoho_created_time',
    ];

    protected $casts = [
        'date' => 'date',
        'shipment_date' => 'date',
        'zoho_created_time' => 'datetime',
        'total' => 'decimal:2',
        'balance' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'total_quantity' => 'decimal:2',
        'total_invoiced_amount' => 'decimal:2',
        'quantity_invoiced' => 'decimal:2',
    ];

    public function invoices()
    {
        return $this->hasMany(SalesOrderInvoice::class);
    }

    public function documents()
    {
        return $this->hasMany(SalesOrderDocument::class);
    }

    public function client()
    {
        return $this->belongsTo(ClientCompany::class,  'customer_id', 'zoho_contact_id',);
    }

    public function investors()
    {
        return $this->belongsToMany(
            Investor::class,
            'investor_salesorders',
            'salesorder_id',
            'investor_id'
        );
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Zoho Upsert
    |--------------------------------------------------------------------------
    */

    public static function upsertFromZoho(array $data)
    {
        $salesOrder = self::updateOrCreate(
            ['zoho_salesorder_id' => $data['salesorder_id']],
            [
                'salesorder_number'     => $data['salesorder_number'] ?? null,
                'date'                  => !empty($data['date']) ? $data['date'] : null,
                'customer_id'           => $data['customer_id'] ?? null,
                'customer_name'         => $data['customer_name'] ?? null,
                'company_name'          => $data['customer_name'] ?? null,
                'reference_number'      => $data['reference_number'] ?? null,
                'current_sub_status'    => $data['current_sub_status'] ?? null,
                'order_status'          => $data['status'] ?? null,
                'invoiced_status'       => $data['invoiced_status'] ?? null,
                'paid_status'           => $data['paid_status'] ?? null,
                'shipped_status'        => $data['shipped_status'] ?? null,
                'delivery_method'       => $data['delivery_method'] ?? null,
                'delivery_method_id'    => $data['delivery_method_id'] ?? null,
                'shipment_date'         => !empty($data['shipment_date']) ? $data['shipment_date'] : null,
                // 'shipment_date'         => !empty($data['shipment_date']) ?? null,
                'total'                 => $data['total'] ?? 0,
                'sub_total'             => $data['sub_total'] ?? 0,
                'discount_total'        => $data['discount_total'] ?? 0,
                'tax_total'             => $data['tax_total'] ?? 0,
                'balance'               => $data['balance'] ?? 0,
                'total_quantity'        => $data['total_quantity'] ?? 0,
                'total_invoiced_amount' => $data['total_invoiced_amount'] ?? 0,
                'quantity_invoiced'     => $data['quantity_invoiced'] ?? 0,
                'created_by_email'      => $data['created_by_email'] ?? null,
                'created_by_name'       => $data['created_by_name'] ?? null,
                'created_by_id'         => !empty($data['created_by_id']) ? (int) $data['created_by_id'] : null,
                'zoho_created_time'     => $data['created_time'] ?? null,
            ]
        );

        // 💼 Sync Line Items
        if (!empty($data['line_items'])) {
            foreach ($data['line_items'] as $line) {
                SalesOrderItem::upsertFromZoho($line, $salesOrder->id);
            }
        }
        // Sync Documents
        
        if (!empty($data['documents'])) {
            $incomingIds = collect($data['documents'])
                ->pluck('document_id')
                ->toArray();

            // 🗑 Delete documents that are NOT in incoming list
            $salesOrder->documents()
                ->whereNotIn('document_id', $incomingIds)
                ->delete();

            // 🔄 Update or Create remaining
            foreach ($data['documents'] as $doc) {
                SalesOrderDocument::updateOrCreate(
                    [
                        'sales_order_id' => $salesOrder->id,
                        'document_id'    => $doc['document_id'],
                    ],
                    [
                        'file_name'        => $doc['file_name'] ?? null,
                        'file_type'        => $doc['file_type'] ?? null,
                        'attachment_order' => $doc['attachment_order'] ?? null,
                    ]
                );
            }
        }

        return $salesOrder;
    }
}
