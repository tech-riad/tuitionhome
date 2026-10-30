<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerApplicationNotesTable extends Migration
{
    public function up()
    {
        Schema::create('career_application_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('career_application_id')
                ->constrained('career_applications')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->text('note');
            $table->timestamps();

            $table->index(['career_application_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('career_application_notes');
    }
}
