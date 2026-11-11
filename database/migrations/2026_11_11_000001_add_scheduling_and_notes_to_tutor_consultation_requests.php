<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchedulingAndNotesToTutorConsultationRequests extends Migration
{
    public function up()
    {
        Schema::table('tutor_consultation_requests', function (Blueprint $table) {
            $table->timestamp('scheduled_at')->nullable()->after('status');
        });

        Schema::create('tutor_consultation_request_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_request_id')
                ->constrained('tutor_consultation_requests')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->text('note');
            $table->timestamps();

            $table->index(['consultation_request_id', 'created_at'], 'consultation_notes_request_created_idx');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tutor_consultation_request_notes');

        Schema::table('tutor_consultation_requests', function (Blueprint $table) {
            $table->dropColumn('scheduled_at');
        });
    }
}
