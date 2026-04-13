<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales_order_invoice_eway_bills', function (Blueprint $table) {

            // ❌ Remove old vehicle_number column
            if (Schema::hasColumn('sales_order_invoice_eway_bills', 'vehicle_number')) {
                $table->dropColumn('vehicle_number');
            }

            // 🔹 Entity Details
            $table->string('entity_id')->nullable()->after('ewaybill_id');
            $table->string('entity_type')->nullable();
            $table->string('entity_number')->nullable();
            $table->string('entity_date_formatted')->nullable();
            $table->integer('entity_status')->nullable();

            // 🔹 GST & Customer
            $table->string('supplier_gstin', 20)->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_gstin', 20)->nullable();

            // 🔹 Ewaybill Core
            $table->dateTime('ewaybill_start_date')->nullable();
            $table->string('ewaybill_type')->nullable();
            $table->integer('validity_days')->nullable();

            // 🔹 Transport
            $table->string('transporter_license')->nullable();
            $table->integer('distance')->nullable();
            $table->string('place_of_dispatch')->nullable();
            $table->string('place_of_delivery')->nullable();
            $table->string('ship_to_state_code', 10)->nullable();
            $table->decimal('entity_total', 15, 2)->default(0);

            // 🔹 Permissions
            $table->boolean('can_allow_print_ewaybill')->default(false);
            $table->boolean('can_allow_cancel_ewaybill')->default(false);

            // 🔹 Vehicle Details JSON
            $table->json('vehicle_details')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('sales_order_invoice_eway_bills', function (Blueprint $table) {

            $table->dropColumn([
                'entity_id',
                'entity_type',
                'entity_number',
                'entity_date_formatted',
                'entity_status',
                'supplier_gstin',
                'customer_name',
                'customer_gstin',
                'ewaybill_start_date',
                'ewaybill_type',
                'validity_days',
                'transporter_license',
                'distance',
                'place_of_dispatch',
                'place_of_delivery',
                'ship_to_state_code',
                'entity_total',
                'can_allow_print_ewaybill',
                'can_allow_cancel_ewaybill',
                'vehicle_details',
            ]);
        });
    }
};