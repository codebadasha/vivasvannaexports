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
        Schema::create('sales_order_invoice_documents', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id')->index();
            $table->string('document_id');
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            $table->integer('attachment_order')->nullable();

            $table->timestamps();

            $table->unique(['invoice_id', 'document_id']);

            $table->foreign('invoice_id')
                ->references('id')
                ->on('sales_order_invoices')
                ->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_invoice_documents');
    }
};
