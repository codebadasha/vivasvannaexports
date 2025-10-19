<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'zoho_item_id',
        'name',
        'account_id',
        'account_name',
        'can_be_purchased',
        'can_be_sold',
        'description',
        'hsn_or_sac',
        'has_attachment',
        'image_document_id',
        'is_taxable',
        'item_type',
        'product_type',
        'purchase_account_id',
        'rate',
        'sku',
        'source',
        'status',
        'track_inventory',
        'unit',
        'created_time',
        'last_modified_time',
        'is_active',
        'is_delete'
    ];

    public function variation()
    {
        return $this->hasMany('App\Models\ProductVariation', 'product_id', 'id');
    }


    public function taxes()
    {
        return $this->hasMany(ProductTax::class, 'product_id');
    }

    /**
     * Common method to map Zoho Item data and upsert in DB
     */
    public static function upsertFromZoho(array $item)
    {
        DB::transaction(function () use ($item) {
            // ✅ 1. Upsert product
            $createdTime = isset($item['created_time']) ? Carbon::parse($item['created_time'])->format('Y-m-d H:i:s') : null;
            $lastModifiedTime = isset($item['last_modified_time']) ? Carbon::parse($item['last_modified_time'])->format('Y-m-d H:i:s') : null;
            $product = self::updateOrCreate(
                ['zoho_item_id' => $item['item_id']],
                [
                    'name'                => $item['name'] ?? null,
                    'account_id'          => $item['account_id'] ?? null,
                    'account_name'        => $item['account_name'] ?? null,
                    'can_be_purchased'    => $item['can_be_purchased'] ?? false,
                    'can_be_sold'         => $item['can_be_sold'] ?? true,
                    'description'         => $item['description'] ?? null,
                    'hsn_or_sac'          => $item['hsn_or_sac'] ?? null,
                    'has_attachment'      => $item['has_attachment'] ?? false,
                    'image_document_id'   => $item['image_name'] ?? null,
                    'is_taxable'          => $item['is_taxable'] ?? true,
                    'item_type'           => $item['item_type'] ?? null,
                    'product_type'        => $item['product_type'] ?? 'goods',
                    'purchase_account_id' => $item['purchase_account_id'] ?? null,
                    'rate'                => $item['rate'] ?? 0,
                    'sku'                 => $item['sku'] ?? null,
                    'source'              => $item['source'] ?? null,
                    'status'              => $item['status'] ?? 'active',
                    'track_inventory'     => $item['track_inventory'] ?? false,
                    'unit'                => $item['unit'] ?? null,
                    'created_time'        => $createdTime,
                    'last_modified_time'  => $lastModifiedTime,
                ]
            );

            $product->taxes()->delete();

            if (!empty($item['item_tax_preferences'])) {
                foreach ($item['item_tax_preferences'] as $taxPref) {

                    // Single-level tax
                    if (!empty($taxPref['tax_id'])) {
                        $product->taxes()->create([
                            'tax_id'         => $taxPref['tax_id'],
                            'tax_type'       => $taxPref['new_tax_type'] ?? null,
                        ]);
                    }
                }
            }
        });
    }
}
