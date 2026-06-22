<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutors')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('emargency_name')->nullable();
            $table->string('emargency_phone')->nullable();
            $table->string('nid_number')->nullable();
            $table->text('full_address')->nullable();
            $table->text('permanent_full_address')->nullable();
            $table->string('additional_phone')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('edited_by')->nullable();
            $table->string('edited_user')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('ssc_c')->nullable();
            $table->string('ssc_m')->nullable();
            $table->string('hsc_c')->nullable();
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
        Schema::dropIfExists('tutor_logs');
    }
}
