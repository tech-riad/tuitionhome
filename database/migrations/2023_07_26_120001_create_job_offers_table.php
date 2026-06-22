<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id');
            $table->string('student_name')->nullable();
            $table->string('student_gender');
            $table->string('institute_name')->nullable();
            $table->bigInteger('category_id');
            $table->bigInteger('course_id');
            $table->Integer('days_in_week');
            $table->time('tutoring_time');
            $table->string('tutoring_duration');
            $table->bigInteger('teaching_method_id');
            $table->string('salary');
            $table->bigInteger('number_of_students');
            $table->bigInteger('country_id');
            $table->bigInteger('city_id');
            $table->bigInteger('location_id');
            $table->text('full_address');
            $table->string('lat_long')->nullable();
            $table->text('tutor_requirement');
            $table->text('special_note')->nullable();
            $table->text('staff_note');
            $table->string('tutor_religion')->nullable();
            $table->string('tutor_gender');
            $table->string('tutor_university_type')->nullable();
            $table->string('year')->nullable();
            $table->bigInteger('tutor_school_id')->nullable();
            $table->bigInteger('tutor_college_id')->nullable();
            $table->string('tutor_board')->nullable();
            $table->string('tutor_group')->nullable();
            $table->unsignedInteger('job_views')->default(0);
            $table->unsignedInteger('total_application')->default(0);
            $table->bigInteger('tutor_curriculam_id')->nullable();
            $table->timestamp('date')->nullable();
            $table->tinyInteger('is_sms_send')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->bigInteger('created_by');
            $table->bigInteger('taken_by_1')->nullable();
            $table->timestamp('taken_by_1_date')->nullable();
            $table->bigInteger('taken_by_2')->nullable();
            $table->timestamp('taken_by_2_date')->nullable();
            $table->bigInteger('reference_id')->nullable();
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
        Schema::dropIfExists('job_offers');
    }
}
