<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parent_personal_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parents_id');
            $table->integer('country_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->text('address_details')->nullable();
            $table->integer('additional_phone')->nullable();
            $table->integer('whats_up_phone')->nullable();
            $table->text('facebook_profile')->nullable();
            $table->text('personal_opinion')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('profession')->nullable();
            $table->string('about_us')->nullable();
            $table->string('children_number')->nullable();
            $table->string('class')->nullable();
            $table->string('category')->nullable();
            $table->string('institute_name')->nullable();
            $table->text('access_token')->nullable();
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
        Schema::dropIfExists('parent_personal_infos');
    }
}
