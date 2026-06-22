<?php

namespace App\Console\Commands;

use App\Models\InactiveTutor;
use App\Models\Tutor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveActiveTutors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:active-tutors';

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
    // public function handle()
    // {
    //     $activeTutors = InactiveTutor::where('is_active', 0)->first();

    //         Tutor::updateOrCreate(['id' => $activeTutors->id], $activeTutors->toArray());
    //         $activeTutors->delete();

    //     $this->info('Active tutors moved successfully.');
    // }

    public function handle()
    {


        $inactiveTutors = InactiveTutor::where('is_active', 0)->get();


        if ($inactiveTutors->isNotEmpty()) {
            foreach ($inactiveTutors as $inactiveTutor) {
                Tutor::updateOrCreate(['id' => $inactiveTutor->id], $inactiveTutor->toArray());
                DB::table('inactive_tutors')->where('id', $inactiveTutor->id)->delete();
            }
            $this->info('Active tutors moved successfully.');
        } else {
            $this->info('No inactive tutors found.');
        }
    }


}