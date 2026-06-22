<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundColumnsToJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            // for refund
            $table->integer('refund_amount')->nullable();
            $table->text('refund_reason')->nullable();
            $table->timestamp('refund_date')->nullable();
            $table->integer('refund_status')->nullable();
            $table->timestamp('refund_complete_date')->nullable();
            $table->integer('refund_complete_amount')->nullable();
            $table->text('refund_complete_note')->nullable();
            $table->integer('refund_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn('refund_amount');
            $table->dropColumn('refund_reason');
            $table->dropColumn('refund_date');
            $table->dropColumn('refund_status');
            $table->dropColumn('refund_complete_date');
            $table->dropColumn('refund_complete_amount');
            $table->dropColumn('refund_complete_note');
            $table->dropColumn('refund_by');
        });
    }
}
