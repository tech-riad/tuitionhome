<?php

namespace App\Console\Commands;

use App\Models\AdvanceSearchSms as ModelsAdvanceSearchSms;
use App\Models\Sms;
use Illuminate\Console\Command;

class AdvanceSearchSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advanceSearchsms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send advance search bulk sms to numbers of sms table';

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
    
            $sms = ModelsAdvanceSearchSms::where('is_send', '0')->inRandomOrder()->first();
    
            if ($sms !== null) {
                $finalsms = ModelsAdvanceSearchSms::where('is_send', '0')->where('body', $sms->body)->inRandomOrder()->limit(30)->get();
                $numbers = [];
    
                foreach ($finalsms as $s) {
                    $numbers[] = "88" . $s->phone;
                    $s->is_send = 1;
                    $s->update();
                    echo "advance Sms Sent " . $s->phone . PHP_EOL;
                }
    
                $numbers = implode(',', $numbers);
    
                ModelsAdvanceSearchSms::smsApiRequest($numbers, $sms->body);
            }
        }
    }
    
}
