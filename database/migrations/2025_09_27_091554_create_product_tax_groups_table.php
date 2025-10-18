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
        Schema::create('product_tax_groups', function (Blueprint $table) {
            $table->id();
            $table->string('tax_group_id', 121);
            $table->foreign('tax_group_id')->references('tax_id')->on('product_taxes')->onDelete('cascade');
            $table->string('tax_id', 121)->unique();
            $table->string('tax_name', 121);
            $table->string('tax_name_formatted', 121)->nullable();
            $table->decimal('tax_percentage', 8, 2)->default(0);
            $table->string('tax_type', 121)->nullable();
            $table->string('tax_account_id', 121)->nullable();
            $table->string('output_tax_account_name', 121)->nullable();
            $table->string('tds_payable_account_id', 121)->nullable();
            $table->string('tax_authority_id', 121)->nullable();
            $table->string('tax_authority_name', 121)->nullable();
            $table->string('tax_specific_type', 121)->nullable();
            $table->boolean('is_state_cess')->default(false);
            $table->string('tax_specification', 121)->nullable();
            $table->string('diff_rate_reason', 121)->nullable();
            $table->string('start_date', 121)->nullable();
            $table->string('end_date', 121)->nullable();
            $table->string('status', 121)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('last_modified_time')->nullable();
            $table->json('raw')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tax_groups');
    }
};
