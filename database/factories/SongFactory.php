<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $name = $this->faker->name(),
            'slug' => Str::slug($name),
            'quality' => '320',
            'duration'=>'3:50',
            'released_date'=>Carbon::now()->subDays(rand(0, 1000)),
        ];
    }
}
