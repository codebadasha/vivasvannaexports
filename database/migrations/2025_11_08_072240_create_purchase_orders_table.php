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
         Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('purchaseorder_id')->unique();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('purchaseorder_number', 161)->unique();
            $table->text('location_name');
            $table->text('reference_number')->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->text('vendor_name');
            $table->text('company_name');
            $table->string('status', 161);
            $table->string('billed_status', 161);
            $table->date('delivery_date')->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->decimal('tax_total', 15, 2)->nullable();
            $table->decimal('discount_total', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
