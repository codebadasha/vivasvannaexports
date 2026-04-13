<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {

            $table->date('submitted_date')->nullable()->after('delivery_date');

            $table->string('submitted_by')->nullable();
            $table->string('submitted_by_name')->nullable();
            $table->string('submitted_by_email')->nullable();

            $table->unsignedBigInteger('submitter_id')->nullable()->index();
            $table->unsignedBigInteger('approver_id')->nullable()->index();

            $table->string('order_status')->nullable();
            $table->string('current_sub_status')->nullable();

            $table->decimal('exchange_rate', 15, 4)->default(1);

            $table->decimal('total_quantity', 15, 2)->default(0);
            $table->decimal('sub_total_inclusive_of_tax', 15, 2)->default(0);

            $table->decimal('discount_percent', 8, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('purchase_orders', function (Blueprint $table) {

            $table->dropColumn([
                'submitted_date',
                'submitted_by',
                'submitted_by_name',
                'submitted_by_email',
                'submitter_id',
                'approver_id',
                'order_status',
                'current_sub_status',
                'exchange_rate',
                'total_quantity',
                'sub_total_inclusive_of_tax',
                'discount_percent',
            ]);
        });
    }
};
