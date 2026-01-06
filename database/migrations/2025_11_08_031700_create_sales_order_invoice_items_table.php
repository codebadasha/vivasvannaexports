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
        Schema::create('sales_order_invoice_items', function (Blueprint $table) {
            $table->id();

            // Relation to sales_order_invoice
            $table->unsignedBigInteger('invoice_id')->nullable();

            // Line item details
            $table->string('line_item_id')->nullable();
            $table->string('item_id')->nullable();
            $table->integer('item_order')->nullable();
            $table->string('product_type')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('quantity', 15, 2)->nullable();
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('bcy_rate', 15, 2)->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->string('tax_id')->nullable();
            $table->string('tax_name')->nullable();
            $table->string('tax_type')->nullable();
            $table->decimal('item_total', 15, 2)->nullable();
            $table->string('pricing_scheme')->nullable();
            $table->string('hsn_or_sac')->nullable();

            $table->timestamps();

            // Foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_invoice_items');
    }
};
