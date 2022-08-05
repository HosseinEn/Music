<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArtistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$name = $this->faker->name(),
            'slug'=>Str::slug($name),
            'created_at'=>Carbon::now()->subDays(rand(0, 365))
        ];
    }
}
