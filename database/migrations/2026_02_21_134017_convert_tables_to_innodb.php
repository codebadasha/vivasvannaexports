<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'api_call_log',
            'client_company_addresses',
            'client_company_invitations',
            'client_gst_details',
            'product_taxes',
            'products',
            'purchase_order_item_taxes',
            'purchase_order_items',
            'purchase_orders',
            'sales_order_invoice_ewaybills',
            'sales_order_invoice_item_taxes',
            'sales_order_invoice_items',
            'sales_order_item_taxes',
            'sales_order_items',
            'supplier_company_addresses',
            'supplier_company_contacts',
            'tax_groups',
            'taxes',
            'zoho_tokens',
            'zoho_webhooks',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            DB::statement("ALTER TABLE `$table` ENGINE=InnoDB;");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(): void
    {
        $tables = [
            'api_call_log',
            'client_company_addresses',
            'client_company_invitations',
            'client_gst_details',
            'product_taxes',
            'products',
            'purchase_order_item_taxes',
            'purchase_order_items',
            'purchase_orders',
            'sales_order_invoice_ewaybills',
            'sales_order_invoice_item_taxes',
            'sales_order_invoice_items',
            'sales_order_item_taxes',
            'sales_order_items',
            'supplier_company_addresses',
            'supplier_company_contacts',
            'tax_groups',
            'taxes',
            'zoho_tokens',
            'zoho_webhooks',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            DB::statement("ALTER TABLE `$table` ENGINE=MyISAM;");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};