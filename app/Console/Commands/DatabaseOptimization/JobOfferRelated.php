<?php

namespace App\Console\Commands\DatabaseOptimization;

use App\Models\JobApplication;
use App\Models\jobOfferLog;
use App\Models\JobStatus;
use App\Models\PremiumMembership;
use App\Models\SmsTemplateLog;
use App\Models\UnverifiedTutor;
use App\Models\VerificationRequest;
use Illuminate\Console\Command;

class JobOfferRelated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobApplication:optimize';

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
        JobStatus::where('created_at', '<', now()->subDays(120))->delete();
        // Delete Repost Job Application older than 1 year
        // and delete related application notes
        JobApplication::where('current_stage', 'repost')
        ->where('repost_date', '<', now()->subYear())
        ->with(['applicationNote'])
        ->chunk(100, function ($applications) {
            foreach ($applications as $application) {
                if ($application->applicationNote) {
                    foreach ($application->applicationNote as $note) {
                        $note->forceDelete();
                    }
                }

                $application->forceDelete();
            }
        });
        // Close applications older than 1 year
        // and delete related application notes
        JobApplication::where('current_stage', 'closed')
        ->where('closed_date', '<', now()->subYear())
        ->with(['applicationNote'])
        ->chunk(100, function ($applications) {
            foreach ($applications as $application) {
                if ($application->applicationNote) {
                    foreach ($application->applicationNote as $note) {
                        $note->forceDelete();
                    }
                }

                $application->forceDelete();
            }
        });
        // Payment applications Note Delete
        JobApplication::where('current_stage', 'confirm')
        ->where('payment_status','paid')
        ->where('paid_date', '<', now()->subYear())
        ->with(['applicationNote'])
        ->chunk(100, function ($applications) {
            foreach ($applications as $application) {
                if ($application->applicationNote) {
                    foreach ($application->applicationNote as $note) {
                        $note->forceDelete();
                    }
                }
            }
        });



        // Delete Job Application older than 1 year
        JobApplication::whereNull('taken_by_id')->where('created_at', '<', now()->subYear());

        // Job offer log older than 1 year
        JobOfferLog::where('created_at', '<', now()->subYear())->delete();

        // Sms Template older than 1 year
        SmsTemplateLog::where('created_at', '<', now()->subYear())->delete();

        // Job Edit Log older than 1 year
        JobOfferLog::where('created_at', '<', now()->subYear())->delete();

        // premium Membership
        PremiumMembership::where('request_status', 'accepted')
            ->orWhere('request_status', 'rejected')
            ->chunk(100, function ($memberships) {
                foreach ($memberships as $membership) {
                    $membership->delete();
                }
            });
        // Verification Request older than 1 year
        VerificationRequest::where('request_status', 'accepted')
            ->where('request_status', 'rejected')
            ->chunk(100, function ($memberships) {
                foreach ($memberships as $membership) {
                    $membership->delete();
                }
            });

        // Unverified Tutor Delete
        UnverifiedTutor::where('created_at', '<', now()->subDays(90))
            ->chunk(100, function ($unverifiedTutors) {
                foreach ($unverifiedTutors as $unverifiedTutor) {
                    $unverifiedTutor->delete();
                }
            });
    }
}
