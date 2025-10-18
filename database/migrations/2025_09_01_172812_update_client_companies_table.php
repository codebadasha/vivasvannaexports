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
            $table->boolean('pan_verify')->default(0)->after('is_verify');
            $table->boolean('msme_verify')->default(0)->after('cin_verify');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_companies', function (Blueprint $table) {
            $table->dropColumn([
                'pan_verify',
                'msme_verify'
            ]);
        });
    }
};
