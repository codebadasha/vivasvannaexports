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
        Schema::create('sales_order_invoices', function (Blueprint $table) {
            $table->id();

            // Relationship to sales_order table
            $table->unsignedBigInteger('salesorder_id')->nullable(); // FK to sales_order.salesorder_id

            // Invoice fields
            $table->string('invoice_id')->nullable();
            $table->bigInteger('investor_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('status')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);

            $table->timestamps();
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
