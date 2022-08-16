<?php

namespace App\Jobs;

use App\Models\Album;
use App\Models\Song;
use App\Services\MoveSongBetweenDisksService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishFiles 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = now();
        $albums = Album::where("publish_date", "<", $now)->where("published", false)->get();
        $songs = Song::soloSongs()->where("publish_date", "<", $now)->where("published", false)->get();
        $moveSongs = new MoveSongBetweenDisksService();


        foreach($albums as $album) {
            $album->published = true;
            $album->save();
            foreach($album->songs as $song) {
                $song->published = true;
                $song->save();
                $moveSongs->moveSongBetweenDisksAndUpdatePath($song);
            }
        }
        foreach($songs as $song) {
            $song->published = true;
            $song->save();
            $moveSongs->moveSongBetweenDisksAndUpdatePath($song);
        }
    }
}
