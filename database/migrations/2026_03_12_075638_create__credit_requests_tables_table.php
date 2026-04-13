<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('credit_request_balance_sheets');
        Schema::dropIfExists('credit_request_gst_score_reports');
        Schema::dropIfExists('credit_request_bank_statement_reports');
        Schema::dropIfExists('credit_requests');

        Schema::create('credit_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_company_id');
            $table->decimal('credit_amount',15,2)->nullable();
            $table->decimal('interest_rate',5,2)->nullable();
            $table->decimal('tolerance',5,2)->nullable();

            $table->enum('request_step',[
                'draft',
                'statement_uploaded',
                'gst_report_fetched',
                'balance_sheet_uploaded'
            ])->default('draft');

            $table->enum('status',[
                'document_pending',
                'submitted',
                'approved',
                'rejected',
                'cancelled'
            ])->default('document_pending');

            $table->text('reason')->nullable();

            $table->timestamps();
        });

        Schema::create('credit_request_bank_statement_reports', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('credit_request_id');

            $table->decimal('request_amount',15,2)->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();

            $table->string('upload_filepath')->nullable();
            $table->string('filepassword')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('perfiosTransactionId')->nullable();
            $table->string('perfiosFileId')->nullable();

            $table->string('accountId')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('accountType')->nullable();

            $table->json('payload')->nullable();
            $table->string('report_file_path')->nullable();

            $table->enum('status',[
                'initialized',
                'uploaded',
                'report_generating',
                'generated',
                'failed'
            ])->default('initialized');

            $table->text('reason')->nullable();

            $table->timestamps();
        });

        Schema::create('credit_request_gst_score_reports', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('credit_request_id');

            $table->string('refID')->nullable();
            $table->string('prfios_requestId')->nullable();
            $table->text('prfios_stamessage')->nullable();

            $table->string('perfios_excexlfilelink')->nullable();
            $table->string('perfios_pdffilelink')->nullable();

            $table->string('local_excexlfilepath')->nullable();
            $table->string('local_pdffilepath')->nullable();

            $table->json('json_payload')->nullable();

            $table->enum('status',[
                'draft',
                'otp_generated',
                'report_generating',
                'generated',
                'failed'
            ])->default('draft');

            $table->text('reason')->nullable();

            $table->timestamps();
        });

        Schema::create('credit_request_balance_sheets', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('credit_request_id');
            $table->string('year');
            $table->string('filepath');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_request_balance_sheets');
        Schema::dropIfExists('credit_request_gst_score_reports');
        Schema::dropIfExists('credit_request_bank_statement_reports');
        Schema::dropIfExists('credit_requests');
    }
};