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
        Schema::create('api_call_log', function (Blueprint $table) {
            $table->id();
            $table->string('service'); // e.g. Surepass
            $table->string('url');
            $table->json('request_data')->nullable();
            $table->string('status')->nullable(); // success, failed
            $table->json('response_data')->nullable();
            $table->timestamp('request_time')->nullable();
            $table->timestamp('response_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_call_log');
    }
};
