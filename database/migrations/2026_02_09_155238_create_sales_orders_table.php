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
        Schema::dropIfExists('sales_orders');
        
        Schema::create('sales_orders', function (Blueprint $table) {
           $table->id();

            $table->string('zoho_salesorder_id')->unique();
            $table->string('salesorder_number')->nullable();
            $table->date('date')->nullable();

            $table->string('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('company_name')->nullable();
            
            $table->string('reference_number')->nullable();
            $table->unsignedBigInteger('project_id')->nullable()->index();

            $table->string('current_sub_status')->nullable();
            $table->string('order_status')->nullable();
            $table->string('invoiced_status')->nullable();
            $table->string('paid_status')->nullable();
            $table->string('shipped_status')->nullable();

            $table->string('delivery_method')->nullable();
            $table->string('delivery_method_id')->nullable();
            $table->date('shipment_date')->nullable();
            
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('total_quantity', 15, 2)->default(0);
            $table->decimal('total_invoiced_amount', 15, 2)->default(0);
            $table->decimal('quantity_invoiced', 15, 2)->default(0);
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('discount_total', 15, 2)->default(0);
            $table->decimal('tax_total', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);

            $table->string('created_by_email')->nullable();
            $table->string('created_by_name')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable()->index();

            $table->timestamp('zoho_created_time')->nullable();
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
