<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Song::factory(20)->make()->each(function($song) {
            $song->artist()->associate(Artist::inRandomOrder()->get()->first());
            $song->user_id = User::inRandomOrder()->get()->first()->id;
            $song->save();
        });
        // songs with albums
        Song::factory(20)->make()->each(function($song) {
            $album = Album::inRandomOrder()->get()->first();
            $artist = $album->artist;
            $song->artist()->associate($artist);
            $song->album()->associate($album);
            $song->user_id = User::inRandomOrder()->get()->first()->id;
            $song->save();
        });
    }
}
