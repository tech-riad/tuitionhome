<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('request_status', ['accepted', 'rejected', 'pending','waiting'])->nullable();
            $table->foreignId('tutor_id')->constrained('tutors')->cascadeOnDelete();
            $table->text('name')->nullable();
            $table->string('action_by')->nullable();
            $table->text('decline_note')->nullable();
            $table->text('waiting_note')->nullable();
            $table->timestamp('waiting_note_update_date')->nullable();
            $table->timestamp('expected_waiting_date')->nullable();
            $table->timestamp('action_at')->nullable();
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
        Schema::dropIfExists('affiliate_requests');
    }
}
