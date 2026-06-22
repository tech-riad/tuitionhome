<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countings', function (Blueprint $table) {
            $table->id();
            $table->string('tutor_id')->dafault(0);
            $table->string('applied_job')->dafault(0);
            $table->string('shortlisted_job')->dafault(0);
            $table->string('appointed_job')->dafault(0);
            $table->string('confirmed_job')->dafault(0);
            $table->string('cancel_job')->dafault(0);
            $table->string('payment_job')->dafault(0);
            $table->string('repost_job')->dafault(0);
            $table->string('due_job')->dafault(0);
            $table->string('refund_job')->dafault(0);
            $table->string('waiting_job')->dafault(0);
            $table->string('meeting_job')->dafault(0);
            $table->string('trial_job')->dafault(0);
            $table->string('problem_job')->dafault(0);
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
        Schema::dropIfExists('countings');
    }
}
