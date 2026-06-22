<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_sms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_offers')->cascadeOnDelete();
            $table->text('sender_name')->nullable();
            $table->bigInteger('sender_id')->nullable();
            $table->text('sms_title')->nullable();
            $table->text('sms_body')->nullable();
            $table->bigInteger('tutor_id')->nullable();
            $table->text('tutor_phone')->nullable();
            $table->enum('sms_method',['pullup','pushup'])->nullable();
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
        Schema::dropIfExists('job_sms');
    }
}
