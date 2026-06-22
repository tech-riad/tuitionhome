<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parents_id');
            $table->integer('country_id');
            $table->integer('city_id');
            $table->integer('location_id');
            $table->string('student_gender')->nullable();
            $table->text('address')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->text('subject_id')->nullable();
            $table->string('tutor_gender')->nullable();
            $table->text('addition_requirement')->nullable();
            $table->string('note')->nullable();
            $table->string('status')->nullable();
            $table->integer('added_by')->nullable();
            $table->foreign('parents_id')->references('id')->on('parents')->onDelete('cascade');
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
        Schema::dropIfExists('leads');
    }
}
