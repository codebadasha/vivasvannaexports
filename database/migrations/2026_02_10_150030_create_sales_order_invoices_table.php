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
        Schema::dropIfExists('sales_order_invoices');
        Schema::create('sales_order_invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sales_order_id')->nullable()->index(); // FK

            $table->string('invoice_id')->unique();
            $table->string('invoice_number')->nullable();
            $table->string('zoho_salesorder_id')->nullable();

            $table->date('date')->nullable();
            $table->date('due_date')->nullable();

            $table->string('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('reference_number')->nullable();

            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('tax_total', 15, 2)->default(0);
            $table->decimal('discount_total', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);

            $table->string('status')->nullable();
            $table->string('current_sub_status')->nullable();

            $table->unsignedBigInteger('created_by_id')->nullable()->index();
            $table->string('created_by_name')->nullable();

            $table->timestamps();

            // 🔥 Foreign key
            $table->foreign('sales_order_id')
                ->references('id')
                ->on('sales_orders')
                ->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_invoices');
    }
};
