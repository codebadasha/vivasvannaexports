<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boq_items', function (Blueprint $table) {
            // Rename column first (if exists)
            if (Schema::hasColumn('boq_items', 'category_id')) {
                $table->renameColumn('category_id', 'product_id');
            }
        });

        Schema::table('boq_items', function (Blueprint $table) {
            // Now ensure correct type (bigInteger)
            $table->bigInteger('product_id')->change();

            // Drop columns if they exist
            if (Schema::hasColumn('boq_items', 'variation_id')) {
                $table->dropColumn('variation_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('boq_items', function (Blueprint $table) {
            // Reverse changes
            $table->renameColumn('product_id', 'category_id');
            $table->integer('variation_id')->nullable();
        });
    }
};
