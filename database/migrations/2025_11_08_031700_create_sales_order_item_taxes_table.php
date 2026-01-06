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
        Schema::create('sales_order_item_taxes', function (Blueprint $table) {
            $table->id();

            // 🔗 Relation to item
            $table->unsignedBigInteger('sales_order_item_id')->nullable();
            $table->bigInteger('sales_order_id')->nullable();

            // 🧾 Tax details
            $table->string('tax_id')->nullable();
            $table->string('tax_name')->nullable();
            $table->decimal('tax_amount', 15, 2)->default(0);
            $table->decimal('tax_percentage', 5, 2)->nullable();
            $table->string('tax_specific_type')->nullable(); // igst, cgst, sgst
            $table->timestamps();

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_item_taxes');
    }
};
