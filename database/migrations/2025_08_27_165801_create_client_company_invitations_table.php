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
        Schema::create('client_company_invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email', 191);
            $table->text('url');
            $table->string('gstn')->nullable();
            $table->string('token', 191)->index()->unique();
            $table->boolean('is_registered')->default(false);
            $table->tinyInteger('status')->default(1)->comment('0=expired, 1=pending, 2=registered');
            $table->boolean('is_master')->default(false)->comment('1 = master link');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_company_invitations');
    }
};
