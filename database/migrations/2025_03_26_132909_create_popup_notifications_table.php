<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['tutor', 'parent']);
            $table->string('placement_url');
            $table->string('navigate_link')->nullable();
            $table->string('image')->nullable();
            $table->enum('click_type', ['popup', 'property'])->default('popup');
            $table->string('updated_audience')->nullable();
            $table->string('status')->nullable();
            $table->string('campain_status')->nullable();
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
        Schema::dropIfExists('popup_notifications');
    }
}
