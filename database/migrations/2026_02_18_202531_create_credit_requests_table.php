<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('credit_requests');
        Schema::create('credit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_company_id')->constrained('client_companies')->onDelete('cascade');
            $table->string('resone')->nullable();
            $table->string('status')->default('DOCUMENT PENDING');
            $table->boolean('bank_statement')->default(0);
            $table->boolean('gst_score')->default(0);
            $table->boolean('balance_sheet')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_requests');
    }
};
