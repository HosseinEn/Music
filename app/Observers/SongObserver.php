<?php

namespace App\Observers;

use App\Models\Album;
use App\Models\Song;
use App\Services\MoveSongBetweenDisksService;

class SongObserver
{
    /**
     * Handle the Song "updating" event.
     *
     * @param  \App\Models\Song  $song
     * @return void
     */
    public function updating(Song $song)
    {
        $moveSong = new MoveSongBetweenDisksService();
        $moveSong->moveSongBetweenDisksAndUpdatePath($song);
    }

    /**
     * Handle the Song "deleting" event.
     *
     * @param  \App\Models\Song  $song
     * @return void
     */
    public function deleting(Song $song)
    {
        $songFiles = $song->songFiles; 
        foreach($songFiles as $songFile) {
            $songFile->delete();
        }
        if($song->image) {
            $song->image->delete();
        }
    }

}
