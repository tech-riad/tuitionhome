<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFnfLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fnf_leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parents_id');
            $table->string('name');
            $table->string('location');
            $table->string('tutor_gender')->nullable();
            $table->string('course')->nullable();
            $table->string('subject')->nullable();
            $table->string('phone');
            $table->string('note')->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('is_cancel')->default(1);
            $table->tinyInteger('is_affiliate')->default(0);
            $table->string('cancel_note')->nullable();
            $table->integer('added_by')->nullable();
            $table->string('ip_address')->nullable();
            $table->foreign('parents_id')->references('id')->on('parents')->onDelete('cascade');
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
        Schema::dropIfExists('fnf_leads');
    }
}
