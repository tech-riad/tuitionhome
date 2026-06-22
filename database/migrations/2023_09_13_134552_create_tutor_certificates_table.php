<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutors')->cascadeOnDelete()->unique();
            $table->string('ssc_c')->nullable();
            $table->string('ssc_m')->nullable();
            $table->string('hsc_c')->nullable();
            $table->string('hsc_m')->nullable();
            $table->string('nid')->nullable();
            $table->string('university_c')->nullable();
            $table->string('diploma_c')->nullable();
            $table->string('post_graduation_c')->nullable();
            $table->string('cv')->nullable();
            $table->string('others')->nullable();


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
        Schema::dropIfExists('tutor_certificates');
    }
}
