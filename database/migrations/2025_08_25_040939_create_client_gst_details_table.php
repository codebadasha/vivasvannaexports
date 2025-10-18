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
        Schema::create('client_gst_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_company_id')->nullable();
            
            $table->string('gstn');
            $table->string('pan');
            $table->string('cin')->nullable();
            $table->string('nature_of_business')->nullable();
            $table->json('promoters')->nullable();
            $table->string('annual_turnover')->nullable();
            $table->string('annual_turnover_fy')->nullable();
            
            $table->string('aadhaar_validation')->nullable();
            $table->date('aadhaar_validation_date')->nullable();
            $table->boolean('einvoice_status')->default(false);
            $table->string('client_id')->nullable();

            $table->string('business_name')->nullable();
            $table->string('legal_name')->nullable();
            $table->text('center_jurisdiction')->nullable();
            $table->text('state_jurisdiction')->nullable();
            $table->date('date_of_registration')->nullable();
            $table->string('constitution_of_business')->nullable();
            $table->string('taxpayer_type')->nullable();
            $table->string('gstin_status')->nullable();
            
            $table->json('nature_bus_activities')->nullable();

            $table->timestamps();

            $table->foreign('client_company_id')->references('id')->on('client_companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_gst_details');
    }
};
