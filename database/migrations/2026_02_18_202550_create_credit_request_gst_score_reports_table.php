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
       Schema::create('credit_request_gst_score_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_request_id')->constrained()->onDelete('cascade');
            $table->string('refID')->nullable();
            $table->string('prfios_requestId')->nullable();
            $table->string('prfios_stamessage')->nullable();
            $table->string('perfios_excexlfilelink')->nullable();
            $table->string('perfios_pdffilelink')->nullable();
            $table->string('local_excexlfilepath')->nullable();
            $table->string('local_pdffilepath')->nullable();
            $table->json('json_payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_request_gst_score_reports');
    }
};
