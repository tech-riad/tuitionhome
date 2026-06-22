<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_images', function (Blueprint $table) {
            $table->id();
            $table->string('user_type');
            $table->string('title')->nullable();
            $table->timestamp('send_now')->nullable();
            $table->string('placement_url')->nullable();
            $table->string('navigate_link')->nullable();
            $table->string('image')->nullable();
            $table->string('status')->default('0');
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
        Schema::dropIfExists('popup_images');
    }
}
