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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->integer('po_id')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->string('reference_number')->nullable();
            $table->enum('type',['PAID','PENDING']);
            $table->double('amount',10,2);
            $table->date('payment_date');
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
        Schema::dropIfExists('transactions');
    }
};
