<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Song;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TaggablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $songs = Song::get();
        $albums = Album::get();
        $tags_count = Tag::count();

        $songs->each(function($song) use ($tags_count) {
            $tags = Tag::inRandomOrder()->get()->take(rand(1, $tags_count))->pluck("id")->toArray();
            $song->tags()->attach($tags);
        });

        $albums->each(function($album) use ($tags_count) {
            $tags = Tag::inRandomOrder()->get()->take(rand(1, $tags_count))->pluck("id")->toArray();;
            $album->tags()->attach($tags);
        });
    }
}
