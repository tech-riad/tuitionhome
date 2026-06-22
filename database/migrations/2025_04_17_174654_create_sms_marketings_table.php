<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsMarketingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_marketings', function (Blueprint $table) {
            $table->id();
            $table->string('user_type');
            $table->string('query');
            $table->string('title');
            $table->string('sms_body');
            $table->string('updated_audience')->nullable();
            $table->string('status')->nullable();
            $table->string('campain_status')->nullable();
            $table->timestamp('send_now')->nullable();
            $table->timestamp('send_latter')->nullable();
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
        Schema::dropIfExists('sms_marketings');
    }
}
