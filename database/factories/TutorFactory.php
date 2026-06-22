<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as faker;


class TutorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            "otp" => 2429,
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            "phone" => '0171232'.rand(1234,9999),
            "gender" => "male",
            "role_id" => "3",
            "password" => Hash::make('111111'),
            // "updated_at" => "2023-09-26T07:32:49.000000Z",
            // "created_at" => "2023-09-26T07:32:49.000000Z",
        ];
    }
}
