<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales_order_invoice_ewaybills', function (Blueprint $table) {
$table->id();

            // Relation to sales_order_invoice
            $table->unsignedBigInteger('invoice_id')->nullable(); // FK

            // E-Way Bill details
            $table->string('ewaybill_id')->nullable();
            $table->string('ewaybill_number')->nullable();
            $table->string('ewaybill_status')->nullable();
            $table->string('ewaybill_status_formatted')->nullable();
            $table->dateTime('ewaybill_date')->nullable();
            $table->dateTime('ewaybill_expiry_date')->nullable();
            $table->string('sub_supply_type')->nullable();
            $table->string('transportation_mode')->nullable();
            $table->string('transporter_id')->nullable();
            $table->string('transporter_name')->nullable();
            $table->string('transporter_registration_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_invoice_ewaybills');
    }
};
