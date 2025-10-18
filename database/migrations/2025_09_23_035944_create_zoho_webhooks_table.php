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
        Schema::create('zoho_webhooks', function (Blueprint $table) {
            $table->id();
            $table->string('module_name', 100);
            $table->string('event', 100);
            $table->string('secret', 100)->nullable();
            $table->text('url')->nullable();
            $table->timestamps();
            $table->unique(['module_name', 'event'], 'zoho_webhooks_module_event_unique'); // Prevent duplicates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoho_webhooks');
    }
};
