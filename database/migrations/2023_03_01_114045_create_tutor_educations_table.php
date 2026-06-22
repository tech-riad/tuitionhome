<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutors')->cascadeOnDelete();
            $table->integer('institute_id')->nullable();
            $table->integer('curriculum_id')->nullable();
            $table->string('degree_name')->nullable();
            $table->integer('degree_id')->nullable();
            $table->string('gpa')->nullable();
            $table->string('education_board')->nullable();
            $table->string('group_or_major')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('currently_studying')->nullable();
            $table->string('degree_title')->nullable();
            $table->text('id_no')->nullable();
            $table->integer('study_type_id')->nullable();
            $table->text('department')->nullable();
            $table->integer('department_id')->nullable();
            $table->string('university_type')->nullable();
            $table->string('year_or_semester')->nullable();
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
        Schema::dropIfExists('tutor_educations');
    }
}
