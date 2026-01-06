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
        Schema::create('sales_order_items', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation to parent sales_order
            $table->unsignedBigInteger('sales_order_id')->nullable();

            // 🧩 Zoho line item identifiers
            $table->string('line_item_id')->nullable();
            $table->string('variant_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('product_id')->nullable();

            // 🏷️ Product info
            $table->string('sku')->nullable();
            $table->string('name')->nullable();
            $table->string('group_name')->nullable();
            $table->text('description')->nullable();

            // 📦 Order & pricing info
            $table->integer('item_order')->nullable();
            $table->decimal('bcy_rate', 15, 2)->nullable();
            $table->decimal('rate', 15, 2)->nullable();
            $table->decimal('sales_rate', 15, 2)->nullable();
            $table->decimal('quantity', 15, 2)->nullable();
            $table->decimal('quantity_manuallyfulfilled', 15, 2)->nullable();
            $table->string('unit')->nullable();
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);

            // 🧾 Tax summary fields
            $table->string('tax_id')->nullable();
            $table->string('tax_name')->nullable();
            $table->string('tax_type')->nullable();
            $table->decimal('tax_percentage', 5, 2)->nullable();

            // 💰 Amount details
            $table->decimal('item_total', 15, 2)->nullable();
            $table->decimal('item_sub_total', 15, 2)->nullable();

            // 🧮 Product metadata
            $table->string('product_type')->nullable();
            $table->string('line_item_type')->nullable();
            $table->string('item_type')->nullable();
            $table->string('hsn_or_sac')->nullable();

            // 🧾 Invoice tracking flags
            $table->boolean('is_invoiced')->default(false);
            $table->decimal('quantity_invoiced', 15, 2)->default(0);
            $table->decimal('quantity_backordered', 15, 2)->default(0);
            $table->decimal('quantity_cancelled', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_items');
    }
};
