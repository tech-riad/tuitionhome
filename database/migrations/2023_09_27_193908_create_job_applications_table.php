<?php

use App\Models\JobOffer;
use App\Models\Tutor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Tutor::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(JobOffer::class)->constrained()->cascadeOnDelete();
            $table->bigInteger('tutor_added_additional_by')->nullable();
            $table->bigInteger('taken_by_id')->nullable();
            $table->timestamp('taken_at')->nullable();
            $table->timestamp('waiting_stage')->nullable();
            $table->timestamp('waiting_date')->nullable();
            $table->time('waiting_time')->nullable();
            $table->date('waiting_follow_up_date')->nullable();
            $table->text('waiting_about')->nullable();
            $table->timestamp('meeting_stage')->nullable();
            $table->timestamp('meeting_date')->nullable();
            $table->time('meeting_time')->nullable();
            $table->date('meeting_follow_up_date')->nullable();
            $table->text('meeting_about')->nullable();
            $table->timestamp('trial_stage')->nullable();
            $table->timestamp('trial_date_1st')->nullable();
            $table->time('trial_time_1st')->nullable();
            $table->timestamp('trial_date')->nullable();
            $table->timestamp('trial_date_2nd')->nullable();
            $table->time('trial_time_2nd')->nullable();

            $table->text('trail_about')->nullable();
            $table->date('trail_follow_up')->nullable();
            $table->text('trial_about')->nullable();






            $table->string('tag')->nullable();
            $table->string('condition')->nullable();



            $table->timestamp('cancel_stage')->nullable();
            $table->date('cancel_follow_up')->nullable();


            $table->timestamp('problem_stage')->nullable();
            $table->timestamp('problem_date')->nullable();
            $table->text('problem_about')->nullable();
            $table->date('problem_follow_up')->nullable();
            $table->text('problem_note')->nullable();
            $table->timestamp('panding_to')->nullable();
            $table->text('cancel_note')->nullable();



            $table->timestamp('repost_date')->nullable();
            $table->text('repost_note')->nullable();
            $table->text('repost_about')->nullable();
            $table->text('repost_problem')->nullable();
            $table->date('repost_follow_up')->nullable();



            $table->text('closed_about')->nullable();
            $table->text('closed_date')->nullable();




            $table->date('payment_follow_up')->nullable();



            $table->timestamp('tutoring_start_date')->nullable();
            $table->double('tuition_salary')->nullable();
            $table->text('job_duration')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->date('confirm_follow_up')->nullable();

            $table->text('percentage')->nullable();
            $table->text('confirm_about')->nullable();
            $table->text('charge')->nullable();
            $table->timestamp('confirm_stage')->nullable();
            $table->timestamp('confirm_date')->nullable();



            $table->text('payment_about')->nullable();



            $table->longText('note')->nullable();
            $table->double('commission')->nullable();
            $table->double('receivable_amount')->nullable();
            $table->double('net_receivable_amount')->nullable();
            $table->tinyInteger('is_reposted')->default(0);
            $table->tinyInteger('is_canceled')->default(0);
            $table->tinyInteger('is_taken')->default(0);
            $table->tinyInteger('is_seen')->default(0);
            $table->tinyInteger('is_tutor_seen')->default(0);
            $table->enum('current_stage',['waiting','meet','trial','confirm','payment','repost','closed','cancel','problem','assign'])->nullable();
            // $table->integer('received_amount')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->tinyInteger('is_payment_turned_off')->default(0);
            $table->text('payment_turned_off_reason')->nullable();
            $table->double('turned_off_amount')->nullable();
            $table->double('reference_amount')->nullable();
            $table->text('ref_taken_note')->nullable();



            $table->timestamp('due_payment_date')->nullable();
            $table->integer('due_amount')->nullable();
            $table->integer('total_due_paid')->nullable();
            $table->integer('received_amount')->nullable();
            $table->text('received_number')->nullable();
            $table->text('payment_method')->nullable();
            $table->text('payment_status')->nullable();
            $table->timestamp('paid_date')->nullable();


            $table->tinyInteger('is_shortlisted')->default(0);
            $table->bigInteger('shortlisted_by')->nullable();
            $table->timestamp('shortlisted_date')->nullable();
            $table->string('seen_by')->nullable();






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
        Schema::dropIfExists('job_applications');
    }
}
