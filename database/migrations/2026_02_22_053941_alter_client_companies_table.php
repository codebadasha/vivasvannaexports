<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_companies', function (Blueprint $table) {

            // 1️⃣ Add team_id column
            $table->foreignId('admin_id')
                  ->nullable()
                  ->after('id') // change position if needed
                  ->constrained('admins')
                  ->onDelete('cascade');
            $table->foreignId('verify_by_id')
                  ->nullable()
                  ->after('id') // change position if needed
                  ->constrained('admins')
                  ->onDelete('cascade');

            // 2️⃣ Modify otp column default to null
            $table->integer('otp')
                  ->nullable()
                  ->default(null)
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('client_companies', function (Blueprint $table) {

            // Drop foreign key + column
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
            $table->dropForeign(['verify_by_id']);
            $table->dropColumn('verify_by_id');

            // Revert otp column (adjust if previous default was different)
            $table->integer('otp')
                  ->default(0)
                  ->nullable(false)
                  ->change();
        });
    }
};