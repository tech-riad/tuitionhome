<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupImageDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_image_data', function (Blueprint $table) {
            $table->id();
            $table->string('user_type');
            $table->string('tutor_id')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('popupnotification_id');
            $table->string('phone')->nullable();
            $table->string('placement_url')->nullable();
            $table->string('navigate_link')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('popup_image_data');
    }
}
