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
            $table->string('cin')->nullable()->change();
            $table->boolean('msme_register')->default(0)->after('pan_number');
            $table->tinyInteger('turnover')->comment('0 = below 50cr, 1 = 50cr-150cr, 2 = 150cr-250cr, 3 = 250cr-500cr, 4 = 500cr-1000cr, 5 = above 1000 cr')->after('msme_register');
            $table->boolean('cin_verify')->default(0)->after('is_verify');
            $table->integer('otp')->default(0)->after('tolerance');
            $table->boolean('is_auto_password')->default(0)->comment('0 = manual, 1 = auto-generated')->after('is_terms_accepted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_companies', function (Blueprint $table) {
            $table->string('cin')->nullable(false)->change();
            $table->dropColumn([
                'msme_register',
                'cin_verify',
                'otp',
                'is_auto_password',
                'turnover'
            ]);
        });
    }
};
