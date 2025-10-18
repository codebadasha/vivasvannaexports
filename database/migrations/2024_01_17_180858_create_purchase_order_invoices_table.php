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
        Schema::create('purchase_order_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('po_id');
            $table->string('invoice_number');
            $table->string('invoice_amount');
            $table->string('invoice_copy');
            $table->tinyInteger('mark_as_paid')->default(0);
            $table->date('due_date');
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
        Schema::dropIfExists('purchase_order_invoices');
    }
};
