<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$csK/3SZe3NmFTV1en3qx9uKMCxgt8HAHZ1wVwSqGZKwQQrUSmM9Mm', // password
            'remember_token' => Str::random(10),
            'is_admin'=>false
        ];
    }


    public function createAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
                'email'=>'admin@gmail.com',
                'is_admin'=>true
            ];
        });
    }
}
