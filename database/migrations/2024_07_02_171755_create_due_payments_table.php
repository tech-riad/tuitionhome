<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('due_payments', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id')->nullable();
            $table->timestamp('paid_date')->nullable();
            $table->string('tutor_id')->nullable();
            $table->string('job_id')->nullable();
            $table->string('user_type')->nullable();
            $table->string('name')->nullable();
            $table->string('service_category')->nullable();
            $table->string('amount')->nullable();
            $table->string('payment_status');
            $table->string('render_by')->nullable();
            $table->string('ownership_by')->nullable();
            $table->string('verified_by')->nullable();
            $table->string('application_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('due_payments');
    }
}
