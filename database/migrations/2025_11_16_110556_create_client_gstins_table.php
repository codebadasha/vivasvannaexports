<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_gstins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zoho_contact_id')->constrained('client_companies')->onDelete('cascade');
            $table->string('gstin', 15);
            $table->string('pan_number', 10);
            $table->string('auth_status')->nullable();
            $table->string('application_status')->nullable();
            $table->string('email_id')->nullable();
            $table->string('gstin_ref_id')->nullable();
            $table->string('mob_num')->nullable();
            $table->string('reg_type')->nullable();
            $table->string('registration_name')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('state')->nullable();
            $table->timestamps();
            $table->unique(['gstin']);
            $table->index('pan_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_gstins');
    }
};