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
        Schema::table('client_company_contacts', function (Blueprint $table) {
            $table->string('contact_person_id')->nullable()->after('client_company_id');
            $table->string('phone')->nullable()->after('mobile');
            $table->string('designation')->nullable()->after('phone');
            $table->boolean('is_primary')->default(0)->after('designation');
            $table->string('email')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_company_contacts', function (Blueprint $table) {
           $table->dropColumn([
                'contact_person_id',
                'phone',
                'designation',
                'is_primary',
            ]);
        });
    }
};
