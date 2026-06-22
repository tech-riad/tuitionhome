<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_notes', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('job_id');
            $table->string('tutor_id');
            $table->string('created_by');
            $table->string('note_title');
            $table->longText('note_details');
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
        Schema::dropIfExists('payment_notes');
    }
}
