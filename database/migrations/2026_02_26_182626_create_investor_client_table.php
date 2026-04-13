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
        Schema::dropIfExists('investor_client');
        Schema::dropIfExists('investor_clients');
        Schema::create('investor_clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('investor_id')->nullable(false); // assumes you have investors table
            $table->foreignId('client_company_id')
                  ->constrained('client_companies')
                  ->onDelete('cascade');
            $table->timestamps();

            $table->index('investor_id');
            $table->index('client_company_id');
            // Prevent duplicate assignments
            $table->unique(['investor_id', 'client_company_id'], 'unique_investor_per_so');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_clients');
    }
};
