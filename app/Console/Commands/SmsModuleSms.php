<?php

namespace App\Console\Commands;

use App\Models\SendSms;
use App\Models\Sms;
use Illuminate\Console\Command;

class SmsModuleSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smsModulSms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send sms module sms to numbers of sms table';

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
    
            $sms = SendSms::where('is_send', '0')->inRandomOrder()->first();
    
            if ($sms !== null) {
                $finalsms = SendSms::where('is_send', '0')->where('body', $sms->body)->inRandomOrder()->limit(30)->get();
                $numbers = [];
    
                foreach ($finalsms as $s) {
                    $numbers[] = "88" . $s->sender_number;
                    $s->is_send = 1;
                    $s->update();
                    echo "advance Sms Sent " . $s->sender_number . PHP_EOL;
                }
    
                $numbers = implode(',', $numbers);
    
                SendSms::smsApiRequest($numbers, $sms->body);
            }
        }
    }
}