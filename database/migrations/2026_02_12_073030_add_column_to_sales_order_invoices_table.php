<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales_order_invoices', function (Blueprint $table) {

            // Add column only if it doesn't exist
            if (!Schema::hasColumn('sales_order_invoices', 'investor_id')) {
                $table->unsignedBigInteger('investor_id')->nullable()->after('id');
            }
        });

        // Add foreign key only if not exists
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'sales_order_invoices' 
            AND COLUMN_NAME = 'investor_id'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (empty($foreignKeys)) {
            Schema::table('sales_order_invoices', function (Blueprint $table) {
                $table->foreign('investor_id')
                      ->references('id')
                      ->on('investors')
                      ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_order_invoices', function (Blueprint $table) {

            // Drop foreign key if exists
            try {
                $table->dropForeign(['investor_id']);
            } catch (\Exception $e) {}

            // Drop column if exists
            if (Schema::hasColumn('sales_order_invoices', 'investor_id')) {
                $table->dropColumn('investor_id');
            }
        });
    }
};
