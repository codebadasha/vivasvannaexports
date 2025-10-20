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
        Schema::create('client_company_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_company_id');
            $table->string('address_id', 121)->unique();
            $table->enum('type', ['billing', 'shipping']);
            $table->string('attention', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('street2', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('state_code', 20)->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->timestamps();

            $table->foreign('client_company_id')->references('id')->on('client_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_company_addresses');
    }
};
