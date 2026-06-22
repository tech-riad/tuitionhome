<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_personal_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutors')->cascadeOnDelete();
            $table->integer('country_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->string('additional_phone')->nullable();
            $table->text('full_address')->nullable();
            $table->text('permanent_full_address')->nullable();
            $table->string('nid_number')->nullable();
            $table->string('nationality')->nullable();
            $table->text('facebook_profile')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('fathers_phone')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('mothers_phone')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->text('short_description')->nullable();
            $table->string('religion')->nullable();
            $table->string('expected_salary')->nullable();
            $table->text('tutoring_experience_details')->nullable();
            $table->string('tutoring_experience')->nullable();
            $table->string('available_day')->nullable();
            $table->string('available_from')->nullable();
            $table->string('available_to')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('linekdin_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('reason_hired')->nullable();
            $table->string('about_yourself')->nullable();
            $table->string('personal_opinion')->nullable();
            $table->text('pic')->nullable();
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
        Schema::dropIfExists('tutor_personal_infos');
    }
}
