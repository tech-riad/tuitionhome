<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePremiumMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('tutors')->cascadeOnDelete();
            $table->enum('request_status', ['accepted', 'rejected', 'pending','waiting'])->nullable();
            $table->text('name')->nullable();
            $table->enum('package_name', ['regular', 'pro', 'advance'])->nullable();
            $table->string('taka')->nullable();
            $table->string('transction_id')->nullable();
            $table->string('payment_status')->nullable();
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
        Schema::dropIfExists('premium_memberships');
    }
}
