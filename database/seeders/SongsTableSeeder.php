<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\SongFile;
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
        $quality = collect(["128", "320"]);
        Song::factory(20)->make()->each(function($song) use($quality) {
            $song->artist()->associate(Artist::inRandomOrder()->get()->first());
            $song->user_id = User::inRandomOrder()->get()->first()->id;
            $song->save();
            $songFile = SongFile::make([
                "duration"=>"1:1:1",
                "quality"=>$quality->random(),
                "path"=>"someplace",
                "extension"=>"mp3"
            ]);
            $song->songFiles()->save($songFile);
        });
        // songs with albums
        Song::factory(20)->make()->each(function($song) use($quality) {
            $album = Album::inRandomOrder()->get()->first();
            $artist = $album->artist;
            $song->artist()->associate($artist);
            $song->album()->associate($album);
            $song->user_id = User::inRandomOrder()->get()->first()->id;
            $song->save();
            $songFile = SongFile::make([
                "duration"=>"1:1:1",
                "quality"=>$quality->random(),
                "path"=>"someplace",
                "extension"=>"mp3"
            ]);
            $song->songFiles()->save($songFile);
        });
    }
}
