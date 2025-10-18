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
        Schema::create('supplier_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_logo')->nullable();
            $table->string('company_name')->nullable();
            $table->text('address');
            $table->integer('state_id');
            $table->string('mobile');
            $table->string('email');
            $table->string('gstn');
            $table->string('iec_code');
            $table->string('pancard');
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
        Schema::dropIfExists('supplier_companies');
    }
};
