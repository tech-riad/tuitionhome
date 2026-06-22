<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_offers')->cascadeOnDelete();
            $table->bigInteger('parent_id');
            $table->string('student_name')->nullable();
            $table->string('student_gender');
            $table->string('institute_name')->nullable();
            $table->text('category_id');
            $table->text('course_id');
            $table->text('subject_id');
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
            $table->text('tutoring_category_id')->nullable();
            $table->text('tutor_course_id')->nullable();
            $table->text('tutor_subject_id')->nullable();
            $table->string('tutor_religion')->nullable();
            $table->string('tutor_gender');
            $table->text('tutor_university_id')->nullable();
            $table->string('tutor_university_type')->nullable();
            $table->text('tutor_study_type_id')->nullable();
            $table->text('tutor_department_id')->nullable();
            $table->string('year')->nullable();
            $table->bigInteger('tutor_school_id')->nullable();
            $table->bigInteger('tutor_college_id')->nullable();
            $table->string('tutor_board')->nullable();
            $table->string('tutor_group')->nullable();
            $table->bigInteger('tutor_curriculam_id')->nullable();
            $table->timestamp('date')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('taken_by_1')->nullable();
            $table->bigInteger('taken_by_2')->nullable();
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
        Schema::dropIfExists('job_offer_logs');
    }
}
