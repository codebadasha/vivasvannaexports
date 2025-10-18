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
        Schema::create('boqs', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('project_id');
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
        Schema::dropIfExists('boqs');
    }
};
