<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


use Illuminate\Database\Eloquent\Factories\Factory;

class ParentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

       
            "name" => Str::random(10),
            "phone" => '0171232'.rand(1234,9999),
            'email' => Str::random(10).'@gmail.com',
            "password" => Hash::make('111111'),
            "otp" => 1902,
            // "updated_at" => "2023-09-26T07:53:12.000000Z",
            // "created_at" => "2023-09-26T07:53:12.000000Z",
        ];
    }
}
