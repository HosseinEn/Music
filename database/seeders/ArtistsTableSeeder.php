<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class ArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Artist::factory(20)->make()->each(function ($artist) {
            $artist->user_id = User::inRandomOrder()->get()->first()->id;
            $artist->save();
        });
    }
}
