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
        Schema::table('client_companies', function (Blueprint $table) {
            // Add new fields
            $table->boolean('is_verify')->default(0)->after('tolerance');
            $table->boolean('is_credit_req')->default(0)->after('is_verify');
            // Drop old fields
            $table->dropColumn([
                'company_logo',
                'registration_cetificate',
                'incorporation',
                'gst_certificate',
                'pan_card',
                'aoa'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_companies', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn([
                'is_credit_req',
                'is_verify'
            ]);

            // Recreate removed fields
            $table->string('company_logo')->nullable();
            $table->string('registration_cetificate')->nullable();
            $table->string('incorporation')->nullable();
            $table->string('gst_certificate')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('aoa')->nullable();
        });
    }
};
