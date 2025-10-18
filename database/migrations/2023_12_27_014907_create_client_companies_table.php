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
        Schema::create('client_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_logo');
            $table->string('company_name');
            $table->text('address');
            $table->integer('state_id');
            $table->string('director_name');
            $table->string('mobile_number');
            $table->string('email_id');
            $table->string('gstn');
            $table->string('cin');
            $table->string('pan_number');
            $table->string('registration_cetificate');
            $table->string('incorporation');
            $table->string('gst_certificate');
            $table->string('pan_card');
            $table->string('bank_statement');
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
        Schema::dropIfExists('client_companies');
    }
};
