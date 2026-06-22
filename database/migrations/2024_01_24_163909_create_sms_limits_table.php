<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_limits', function (Blueprint $table) {
            $table->id();
            $table->string('latest_created_input')->nullable();
            $table->string('second_latest_created')->nullable();
            $table->string('random')->nullable();
            $table->string('bottom')->nullable();
            $table->string('second_bottom')->nullable();
            $table->string('premium')->nullable();
            $table->string('send_sms_range')->nullable();
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
        Schema::dropIfExists('sms_limits');
    }
}
