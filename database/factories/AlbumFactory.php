<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$name = $this->faker->unique()->word(),
            'slug'=>Str::slug($name),
            'released_date'=>Carbon::now()->subDays(rand(0, 1000)),
            'duration'=>'2:23',
            'published' => false
        ];
    }
}
