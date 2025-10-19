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
        Schema::dropIfExists('products');

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('zoho_item_id',161)->unique(); // item_id
            $table->string('name'); // item_name
            $table->string('account_id')->nullable(); // Sales or Purchase Account ID
            $table->string('account_name')->nullable();
            $table->boolean('can_be_purchased')->default(false);
            $table->boolean('can_be_sold')->default(true);
            $table->text('description')->nullable();
            $table->string('hsn_or_sac')->nullable();
            $table->boolean('has_attachment')->default(false);
            $table->string('image_document_id')->nullable();
            $table->boolean('is_taxable')->default(true);
            $table->string('item_type')->nullable(); // e.g., sales, purchase
            $table->string('product_type')->default('goods');
            $table->string('purchase_account_id')->nullable();
            $table->decimal('rate', 10, 2)->nullable();
            $table->string('sku')->nullable();
            $table->string('source')->nullable(); // e.g., user
            $table->string('status')->default('active');
            $table->boolean('track_inventory')->default(false);
            $table->string('unit')->nullable();
            $table->timestamp('created_time')->nullable();
            $table->timestamp('last_modified_time')->nullable();
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
