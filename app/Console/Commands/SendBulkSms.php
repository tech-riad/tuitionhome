<?php

namespace App\Console\Commands;

use App\Models\Sms;
use Illuminate\Console\Command;

class SendBulkSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bulksms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send  bulk sms to numbers of sms table';

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
     * @return mixed
     */
    public function handle()
    {
        echo 'start';

        for ($i = 0; $i < 2; $i++) {
            echo $i . PHP_EOL;

            $sms = Sms::where('sent', '0')->inRandomOrder()->first();

            if ($sms !== null) {
                $finalsms = Sms::where('sent', '0')->where('body', $sms->body)->inRandomOrder()->limit(30)->get();
                $numbers = [];

                foreach ($finalsms as $s) {
                    $numbers[] = "88" . $s->phone;
                    $s->sent = 1;
                    $s->update();
                    echo "Sent " . $s->phone . PHP_EOL;
                }

                $numbers = implode(',', $numbers);

                Sms::smsApiRequest($numbers, $sms->body);
            }
        }
    }
}