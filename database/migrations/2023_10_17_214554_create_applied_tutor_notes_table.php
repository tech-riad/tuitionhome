<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliedTutorNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_tutor_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')
            ->constrained('job_applications')
            ->onDelete('cascade');
            $table->foreignId('user_id')
            ->constrained('users')
            ->onDelete('cascade');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('applied_tutor_notes');
    }
}
