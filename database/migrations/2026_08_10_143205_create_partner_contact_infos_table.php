<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerContactInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_contact_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->unique();
            $table->string('country_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('location_id')->nullable();
            $table->string('address')->nullable();
            $table->string('additional_phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('personal_opinion')->nullable();

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
        Schema::dropIfExists('partner_contact_infos');
    }
}
