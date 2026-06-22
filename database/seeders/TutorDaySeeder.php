<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;

class TutorDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tutor_days = ["Saturday","Sunday","Monday","Tuesday","Wednesday","Thursday","Firday"];
        foreach ($tutor_days as $tutor_day)
        {
            Day::create(['title'=>$tutor_day]);
        }
    }
}
