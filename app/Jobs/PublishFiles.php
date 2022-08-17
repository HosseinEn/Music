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
        $albums = Album::where("auto_publish", true)->where("publish_date", "<", $now)->where("published", false)->get();
        $songs = Song::soloSongs()->where("auto_publish", true)->where("publish_date", "<", $now)->where("published", false)->get();

        foreach($albums as $album) {
            // Album observer handle file transfer and song updates
            $album->update(["published"=>true]);
        }
        foreach($songs as $song) {
            // Song observer handle file transfer and song updates
            $song->update(["published"=>true]);
        }
    }
}
