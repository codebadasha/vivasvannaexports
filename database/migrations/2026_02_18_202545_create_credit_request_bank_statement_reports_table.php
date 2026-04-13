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
       Schema::create('credit_request_bank_statement_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_request_id')->constrained()->onDelete('cascade');
            $table->decimal('credit_amount', 15, 2)->nullable();
            $table->foreignId('bank_id')->constrained('banks')->nullable();
            $table->string('file')->nullable();
            $table->string('filepassword')->nullable();
            $table->string('perfiosTransactionId')->nullable();
            $table->string('perfiosFileId')->nullable();
            $table->string('accountId')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('accountType')->nullable();
            $table->boolean('complete')->default(false);
            $table->json('json_payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_request_bank_statement_reports');
    }
};
