<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(1)->create();
        //  \App\Models\Tutor::factory(2)->create();
         \App\Models\Parents::factory(2)->create();
         $this->call(RolePermissionSeeder::class);
         $this->call(TeachingMethodSeeder::class);
         $this->call(TutorDaySeeder::class);


    }
}
