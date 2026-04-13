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
        Schema::create('sales_order_invoice_eway_bills', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id')->index();

            $table->string('ewaybill_id');
            $table->string('ewaybill_number')->nullable();
            $table->string('vehicle_number')->nullable();

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

            $table->unique(['invoice_id', 'ewaybill_id']);

            $table->foreign('invoice_id')
                ->references('id')
                ->on('sales_order_invoices')
                ->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_invoice_eway_bills');
    }
};
