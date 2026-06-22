<?php

namespace App\Console\Commands\DatabaseOptimization;

use App\Console\Commands\AdvanceSearchSms;
use App\Models\AdvanceSearchSms as ModelsAdvanceSearchSms;
use App\Models\Counting;
use App\Models\JobApplication;
use App\Models\JobStatus;
use App\Models\Tutor;
use Illuminate\Console\Command;

class Sms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Delete SMS older than 90 days
        ModelsAdvanceSearchSms::where('created_at', '<', now()->subDays(90))->delete();

        // Delete Job Status older than 90 days



        $savedCount = 0;



        Tutor::chunk(1000, function ($tutors) use (&$savedCount) {
            foreach ($tutors as $tutor) {
                // Applied
                $tutorapplied = JobApplication::where('tutor_id', $tutor->id)->count();

                // Appointed
                $tutorAppointed = JobApplication::where('tutor_id', $tutor->id)
                    ->whereNotNull('taken_at')
                    ->count();

                // Shortlisted
                $tutorShortlisted = JobApplication::where('tutor_id', $tutor->id)
                    ->where('is_shortlisted', 1)
                    ->count();

                // Confirmed
                $tutorConfirm = JobApplication::where('tutor_id', $tutor->id)
                    ->whereNotNull('confirm_date')
                    ->count();

                // Payment
                $tutorPayment = JobApplication::where('tutor_id', $tutor->id)
                    ->whereNotNull('payment_status')
                    ->whereNotNull('payment_date')
                    ->count();

                // Cancelled
                $tutorCancel = JobApplication::where('tutor_id', $tutor->id)
                    ->where(function ($query) {
                        $query->whereNotNull('closed_date')
                            ->orWhereNotNull('repost_date');
                    })
                    ->count();
                $tutorWaiting = JobApplication::where('tutor_id', $tutor->id)
                    ->where('current_stage','waiting')
                    ->count();
                $tutorRepost = JobApplication::where('tutor_id', $tutor->id)
                    ->where('current_stage','repost')
                    ->count();
                $tutorMetting = JobApplication::where('tutor_id', $tutor->id)
                    ->where('current_stage','meet')
                    ->count();
                $tutorTrial = JobApplication::where('tutor_id', $tutor->id)
                    ->where('current_stage','trial')
                    ->count();
                $tutorProblem = JobApplication::where('tutor_id', $tutor->id)
                    ->where('current_stage','problem')
                    ->count();

                // Due
                $paidStatus = true;

            $tutorDue = JobApplication::where('tutor_id', $tutor->id)
                ->when($paidStatus, function ($query) {
                    return $query->where('payment_status', 'due');
                })
                ->count();

            // Refund
            $paidStatus = true;

            $tutorRefund = JobApplication::where('tutor_id', $tutor->id)
                ->when($paidStatus, function ($query) {
                    return $query->where('payment_status', 'refund');
                })
                ->count();
            // Create or update Counting record
            $tutorCountings = Counting::firstOrNew(['tutor_id' => $tutor->id]);

            $tutorCountings->applied_job = $tutorapplied;
            $tutorCountings->appointed_job = $tutorAppointed;
            $tutorCountings->shortlisted_job = $tutorShortlisted;
            $tutorCountings->confirmed_job = $tutorConfirm;
            $tutorCountings->payment_job = $tutorPayment;
            $tutorCountings->cancel_job = $tutorCancel;
            $tutorCountings->waiting_job = $tutorWaiting;
            $tutorCountings->repost_job = $tutorRepost;
            $tutorCountings->meeting_job = $tutorMetting;
            $tutorCountings->trial_job = $tutorTrial;
            $tutorCountings->problem_job = $tutorProblem;
            $tutorCountings->due_job = $tutorDue;
            $tutorCountings->refund_job = $tutorRefund;

                if ($tutorCountings->save()) {
                    $savedCount++;
                }
            }
        });

        // Return number of saved/upserted records
        return $savedCount;
    }



}