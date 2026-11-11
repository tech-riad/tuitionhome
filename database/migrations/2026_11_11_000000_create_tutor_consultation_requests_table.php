<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorConsultationRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('tutor_consultation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutors')->cascadeOnDelete();
            $table->string('topic', 150)->nullable();
            $table->text('message')->nullable();
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->index(['tutor_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutor_consultation_requests');
    }
}
