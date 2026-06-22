<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_children', function (Blueprint $table) {
            $table->id();
            $table->string('student_name')->nullable();
            $table->string('student_gender');
            $table->string('institute_name')->nullable();
            $table->string('category_id');
            $table->string('course_id');
            $table->bigInteger('created_by');
            $table->foreignId('parent_id')->constrained('parents')->cascadeOnDelete();
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
        Schema::dropIfExists('additional_children');
    }
}
