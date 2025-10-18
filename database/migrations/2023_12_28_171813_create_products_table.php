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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->id();
            $table->string('zoho_item_id')->unique();
            $table->string('name');
            $table->decimal('rate', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('tax_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('product_type')->default("goods");
            $table->string('status')->default("active");
            $table->string('unit')->nullable();
            $table->decimal('purchase_rate', 10, 2)->nullable();
            $table->string('purchase_account_id')->nullable();
            $table->string('inventory_account_id')->nullable();
            $table->decimal('initial_stock', 10, 2)->nullable();
            $table->decimal('initial_stock_rate', 10, 2)->nullable();
            $table->decimal('reorder_level', 10, 2)->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
