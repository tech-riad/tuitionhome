<?php

namespace App\Console\Commands;

use App\Models\JobOffer;
use Illuminate\Console\Command;

class ScheduleJobPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Job Post';

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
        $scheduleOffers = JobOffer::whereDate('hire_date', today())
                        ->where('is_active',0)
                        ->whereNull('schedule_posted')
                        ->get();
        foreach ($scheduleOffers as $item) {
            $item->is_active = 1;
            $item->schedule_posted = $item->hire_date;
            $item->update();
        }
    }
}
