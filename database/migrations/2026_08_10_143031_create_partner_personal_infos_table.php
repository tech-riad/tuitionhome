<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_personal_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id')->unique();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('profession')->nullable();
            $table->string('known_from')->nullable();
            $table->string('institute')->nullable();
            $table->string('institute_category')->nullable();
            $table->string('institute_designation')->nullable();
            $table->string('work_experience')->nullable();
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
        Schema::dropIfExists('partner_personal_infos');
    }
}
