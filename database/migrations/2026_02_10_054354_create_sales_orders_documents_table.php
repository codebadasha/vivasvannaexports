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
        Schema::create('sales_order_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sales_orders_id')
                ->constrained('sales_orders')
                ->onDelete('cascade');

            $table->string('document_id');
            $table->string('file_name');
            $table->string('file_type')->nullable();
            $table->integer('attachment_order')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_documents');
    }
};
