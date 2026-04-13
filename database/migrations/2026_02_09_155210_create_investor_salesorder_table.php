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
        Schema::dropIfExists('investor_salesorders');
        
        Schema::create('investor_salesorders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('investor_id')->nullable(false); // assumes you have investors table
            $table->foreignId('salesorder_id')
                  ->constrained('sales_orders')
                  ->onDelete('cascade');
            $table->timestamps();

            $table->index('investor_id');
            $table->index('salesorder_id');
            // Prevent duplicate assignments
            $table->unique(['investor_id', 'salesorder_id'], 'unique_investor_per_so');    
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_salesorders');
    }
};
