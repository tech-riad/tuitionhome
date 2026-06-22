<?php

namespace App\Console\Commands;

use App\Models\JobSms;
use Illuminate\Console\Command;

class JobOfferSmsSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsms:send';

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
        echo 'start';

        for ($i = 0; $i < 2; $i++) {
            echo $i . PHP_EOL;

            $sms = JobSms::where('is_sent', '0')->inRandomOrder()->first();

            if ($sms !== null) {
                $finalsms = JobSms::where('is_sent', '0')->where('sms_body', $sms->sms_body)->inRandomOrder()->limit(30)->get();
                $numbers = [];

                foreach ($finalsms as $s) {
                    $numbers[] = "88" . $s->tutor_phone;
                    $s->is_sent = 1;
                    $s->update();
                    echo "advance Sms Sent " . $s->tutor_phone . PHP_EOL;
                }

                $numbers = implode(',', $numbers);

                JobSms::smsApiRequest($numbers, $sms->sms_body);
            }
        }

    }
}
