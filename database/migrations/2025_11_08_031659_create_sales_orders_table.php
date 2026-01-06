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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salesorder_id')->unique(); 
            $table->string('salesorder_number', 161)->unique();
            $table->bigInteger('project_id')->nullable();
            $table->bigInteger('customer_id');
            $table->date('date');
            $table->string('status', 100);
            $table->date('shipment_date')->nullable();
            $table->string('reference_number', 161);
            $table->string('customer_name', 255);
            $table->string('place_of_supply', 50);
            $table->string('tax_specification', 50);
            $table->boolean('is_taxable')->nullable();
            $table->string('email', 255)->nullable();
            $table->string('currency_id', 255);
            $table->string('currency_code', 255);
            $table->string('currency_symbol', 255);
            $table->boolean('is_discount_before_tax')->nullable();
            $table->text('delivery_method')->nullable();
            $table->bigInteger('delivery_method_id')->nullable();
            $table->string('order_status', 255);
            $table->string('shipped_status', 255);
            $table->string('invoiced_status', 255);
            $table->string('paid_status', 255);
            $table->string('created_by_email', 255)->nullable();
            $table->string('created_by_name', 255)->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->string('location_name', 100)->nullable();
            $table->bigInteger('total_quantity')->default(0);
            $table->boolean('is_emailed')->default(false);
            
            
            $table->decimal('total_invoiced_amount', 15, 2)->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->decimal('tax_total', 15, 2)->nullable();
            $table->decimal('discount_total', 15, 2)->nullable();
            $table->decimal('balance', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
