<?php

namespace App\Console\Commands;

use App\Models\MarketeingSms;
use Illuminate\Console\Command;

class MarketingSmsSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marketing:smsSend';

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

            $sms = MarketeingSms::where('status', '0')->inRandomOrder()->first();



            if ($sms !== null) {
                $finalsms = MarketeingSms::where('status', '0')->where('sms_body', $sms->sms_body)->inRandomOrder()->limit(2000)->get();
                // dd($finalsms->toarray());
                $numbers = [];

                foreach ($finalsms as $s) {
                    $numbers[] = "88" . $s->phone;
                    $s->status = 1;
                    $s->update();
                    echo "Sent " . $s->phone . PHP_EOL;
                }

                $numbers = implode(',', $numbers);

                // dd($numbers);

                MarketeingSms::smsApiRequest($numbers, $sms->sms_body);
            }
        }
    }
}
