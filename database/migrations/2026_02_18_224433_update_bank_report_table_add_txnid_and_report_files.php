<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('credit_request_bank_statement_reports', function (Blueprint $table) {
            // 1. Store txnId (clientTransactionId sent in Initiate)
            $table->string('txn_id')->nullable()->after('perfiosTransactionId');

            // 2. Local paths for downloaded reports
            $table->string('local_pdf_filepath')->nullable()->after('json_payload');
            $table->string('local_excel_filepath')->nullable()->after('local_pdf_filepath');
        });
    }

    public function down()
    {
        Schema::table('credit_request_bank_statement_reports', function (Blueprint $table) {
            $table->dropColumn(['txn_id', 'local_pdf_filepath', 'local_excel_filepath']);
        });
    }
};