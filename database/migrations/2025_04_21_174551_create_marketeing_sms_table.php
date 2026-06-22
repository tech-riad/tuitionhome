<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketeingSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketeing_sms', function (Blueprint $table) {
            $table->id();
            $table->string('user_type');
            $table->string('tutor_id')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('marketing_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('sms_body')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('marketeing_sms');
    }
}
