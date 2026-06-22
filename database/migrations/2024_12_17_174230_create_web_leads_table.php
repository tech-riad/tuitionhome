<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_leads', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('location')->nullable();
            $table->string('class')->nullable();
            $table->string('tutor_gender')->nullable();
            $table->string('phone');
            $table->string('status');
            $table->string('action_by');
            $table->text('cancel_note');
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
        Schema::dropIfExists('web_leads');
    }
}
