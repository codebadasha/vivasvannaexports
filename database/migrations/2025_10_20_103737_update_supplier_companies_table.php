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
        Schema::table('supplier_companies', function (Blueprint $table) {
            $table->string('company_logo')->nullable()->change();
            $table->string('zoho_contact_id', 121)->nullable()->after('company_logo');
            $table->string('company_name')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->integer('state_id')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('gstn')->nullable()->change();
            $table->string('iec_code')->nullable()->change();
            $table->string('pancard')->nullable()->change();
            $table->string('gstn_image')->nullable()->change();
            $table->string('iec_code_image')->nullable()->change();
            $table->string('pancard_image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('supplier_companies', function (Blueprint $table) {
            $table->string('company_logo')->nullable(false)->change();
            $table->string('company_name')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->integer('state_id')->nullable(false)->change();
            $table->string('mobile')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('gstn')->nullable(false)->change();
            $table->string('iec_code')->nullable(false)->change();
            $table->string('pancard')->nullable(false)->change();
            $table->string('gstn_image')->nullable(false)->change();
            $table->string('iec_code_image')->nullable(false)->change();
            $table->string('pancard_image')->nullable(false)->change();
            $table->dropColumn([
                'zoho_contact_id'
            ]);
        });
    }
};
