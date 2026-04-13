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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('zoho_user_id')->nullable()->after('id');
            $table->string('user_role')->after('zoho_user_id')->nullable();
            $table->string('zoho_role_id')->nullable()->after('user_role');

            $table->string('mobile')->nullable()->change(); // if already exists

            $table->tinyInteger('is_auto_generate')->after('password')->default(0);
            $table->string('invitation_type')->after('is_auto_generate')->nullable();
            $table->boolean('is_super_admin')->after('invitation_type')->default(false);
            $table->boolean('is_current_user')->after('is_super_admin')->default(false);

            $table->text('photo_url')->after('is_current_user')->nullable();

            $table->boolean('is_customer_segmented')->after('photo_url')->default(false);
            $table->boolean('is_vendor_segmented')->after('is_customer_segmented')->default(false);
            $table->boolean('is_employee')->after('is_vendor_segmented')->default(false);

            $table->string('source')->after('is_employee')->nullable();
            // $table->dropColumn('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn([
                'zoho_user_id',
                'zoho_role_id',
                'invitation_type',
                'is_super_admin',
                'user_role',
                'is_current_user',
                'photo_url',
                'is_customer_segmented',
                'is_vendor_segmented',
                'is_employee',
                'source',
            ]);
        });
    }
};
