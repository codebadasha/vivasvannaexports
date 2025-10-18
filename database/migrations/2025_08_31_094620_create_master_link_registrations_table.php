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
        Schema::create('master_link_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invitation_id');
            $table->string('gstn', 191);

            $table->foreign('invitation_id')
                ->references('id')
                ->on('client_company_invitations')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_link_registrations');
    }
};
