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
        Schema::table('master_link_registrations', function (Blueprint $table) {
           $table->unsignedBigInteger('client_company_id')->nullable()->after('id');
           $table->foreign('client_company_id')
            ->references('id')
            ->on('client_companies')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_link_registrations', function (Blueprint $table) {
            $table->dropForeign(['client_company_id']);
            $table->dropColumn('client_company_id');
        });
    }
};
