<?php

namespace App\Console\Commands;

use App\Models\InactiveTutor;
use App\Models\Tutor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MoveInactiveTutors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move:inactive-tutors';

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
    $inactiveTutors = Tutor::where('is_active', 0)->get();

    $this->info(count($inactiveTutors) . ' inactive tutors found.');

    foreach ($inactiveTutors as $tutor) {
        $this->info('Moving tutor: ' . $tutor->id);

        $inactiveTutorData = $tutor->toArray();
        InactiveTutor::create($inactiveTutorData);

        $this->info('Inactive tutor created: ' . $tutor->id);

        DB::table('tutors')->where('id', $tutor->id)->delete();

        $this->info('Tutor completely removed: ' . $tutor->id);
    }

    $this->info('Inactive tutors moved successfully.');
}

}
