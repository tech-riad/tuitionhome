<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sms;

class TutorSmsSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tutor:sms-send {tutor_id} {tutor_numbers} {sms_body} {job_id} {title_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send SMS to tutors';

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
        try {
            $tutorId = $this->argument('tutor_id');
            $tutorNumbers = explode(',', $this->argument('tutor_numbers'));
            $smsBody = $this->argument('sms_body');
            $jobId = $this->argument('job_id');
            $titleId = $this->argument('title_id');

            $this->info('Start');

            // Your SMS sending logic goes here...
            for ($i = 0; $i < 2; $i++) {
                $this->info($i);

                $sms20 = Sms::where('sent', '0')->inRandomOrder()->first();

                if ($sms20 !== null) {
                    $sms = Sms::where('sent', '0')->where('body', $sms20->body)->inRandomOrder()->limit(30)->get();
                    $tutorNumbers = [];

                    foreach ($sms as $s) {
                        $tutorNumbers[] = "88" . $s->phone;
                        $s->sent = 1;
                        $s->update();
                        $this->info("Sent " . $s->phone);
                    }

                    $tutorNumbers = implode(',', $tutorNumbers);
                    Sms::smsApiRequest($tutorNumbers, $sms20->body);
                }
            }

            $this->info('SMS sending job completed.');
            return 0;
        } catch (\Exception $e) {
            logger()->error($e);
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
