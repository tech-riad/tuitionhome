<?php

namespace Database\Seeders;

use App\Models\TeachingMethod;
use Illuminate\Database\Seeder;

class TeachingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeachingMethod::create([
            'name' => 'Teacher Home'
        ]);
        TeachingMethod::create([
            'name' => 'Students Home'
        ]);
        TeachingMethod::create([
            'name' => 'Online'
        ]);
    }
}
