<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsRechargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_recharges', function (Blueprint $table) {
            $table->id();
            $table->string('tutor_id');
            $table->string('payment_method');
            $table->string('amount');
            $table->string('recharge_title');
            $table->string('invoice_no')->unique()->nullable();
            $table->string('sms_quantity');
            $table->string('costing');
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
        Schema::dropIfExists('sms_recharges');
    }
}