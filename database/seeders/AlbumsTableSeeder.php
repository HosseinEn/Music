<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Database\Seeder;

class AlbumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Album::factory(20)->make()->each(function($album) {
            $album->artist()->associate(Artist::inRandomOrder()->get()->first());
            $album->user_id = User::inRandomOrder()->get()->first()->id;

            $album->save();
        });
    }
}
