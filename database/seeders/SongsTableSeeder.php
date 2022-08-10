<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
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
        $genre = collect(["New age", "Modern Classic", "Lo-Fi", "Pop", "Funk"]);
        Song::factory(20)->make()->each(function($song) use ($genre) {
            $song->artist()->associate(Artist::inRandomOrder()->get()->first());
            $song->genre = $genre->random();
            $song->save();
        });
        // songs with albums
        Song::factory(20)->make()->each(function($song) use ($genre) {
            $album = Album::inRandomOrder()->get()->first();
            $artist = $album->artist;
            $song->artist()->associate($artist);
            $song->album()->associate($album);
            $song->genre = $genre->random();
            $song->save();
        });
    }
}
