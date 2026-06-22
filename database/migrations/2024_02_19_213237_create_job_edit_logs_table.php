<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobEditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_edit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_offers')->cascadeOnDelete();
            $table->bigInteger('parent_id')->nullable();
            $table->string('student_name')->nullable();
            $table->string('student_gender')->nullable();
            $table->string('institute_name')->nullable();
            $table->text('category_id')->nullable();
            $table->text('course_id')->nullable();
            $table->text('subject_id')->nullable();
            $table->Integer('days_in_week')->nullable();
            $table->time('tutoring_time')->nullable();
            $table->string('tutoring_duration')->nullable();
            $table->bigInteger('teaching_method_id')->nullable();
            $table->string('salary')->nullable();
            $table->bigInteger('number_of_students')->nullable();
            $table->bigInteger('country_id')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->text('full_address')->nullable();
            $table->string('lat_long')->nullable()->nullable();
            $table->text('tutor_requirement')->nullable();
            $table->text('special_note')->nullable()->nullable();
            $table->text('staff_note')->nullable();
            $table->text('tutoring_category_id')->nullable();
            $table->text('tutor_course_id')->nullable();
            $table->text('tutor_subject_id')->nullable();
            $table->string('tutor_religion')->nullable();
            $table->string('tutor_gender')->nullable();
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
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('job_edit_logs');
    }
}
