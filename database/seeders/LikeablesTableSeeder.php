<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;

class LikeablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $users->each(function($user) {
            $user->likedSongs()->attach(Song::inRandomOrder()->take(rand(0, Song::count()))->pluck('id')->toArray());
            $user->likedAlbums()->attach(Album::inRandomOrder()->take(rand(0, Album::count()))->pluck('id')->toArray());
            $user->likedArtists()->attach(Artist::inRandomOrder()->take(rand(0, Artist::count()))->pluck('id')->toArray());
        });
    }
}
