<?php

namespace App\Observers;

use App\Models\Album;
use App\Models\Song;
use App\Services\MoveSongBetweenDisksService;

class AlbumObserver
{
    public function createDuration(& $validatedData) {
        $seconds = $validatedData["duration_seconds"];
        $minutes = $validatedData["duration_minutes"];
        $hours   = $validatedData["duration_hours"];
        $this->unsetDurationSubsets($validatedData);
        return $hours . ':' . $minutes . ':' . $seconds;
    }

    public function unsetDurationSubsets(& $validatedData) {
        unset($validatedData["duration_seconds"]);
        unset($validatedData["duration_minutes"]);
        unset($validatedData["duration_hours"]);
    }
    
    /**
     * Handle the Album "creating" event.
     *
     * @param  \App\Models\Album  $album
     * @return void
     */
    public function created(Album $album)
    {
        $album->tags()->attach(request()->tags);
        $this->addSongsToAlbum($album, request()->songs);
        $this->updateRelatedSongs($album);
    }


    public function updateRelatedSongs($album) {
        $songs = $album->songs;
        $moveSongs = new MoveSongBetweenDisksService();
        foreach($songs as $song) {
            $song->published = $album->published;
            $song->auto_publish = $album->auto_publish;
            $song->publish_date = $album->publish_date;
            $song->save();
            $moveSongs->moveSongBetweenDisksAndUpdatePath($song);
        }
    }
    
    /**
     * Handle the Album "updating" event.
     *
     * @param  \App\Models\Album  $album
     * @return void
     */
    public function updating(Album $album)
    {
        $this->updateRelatedSongs($album);
    }

    public function saving(Album $album) {
        $this->addSongsToAlbum($album, request()->songs);
    }

    public function addSongsToAlbum($album, $songs) {
        $songs = Song::whereIn('id', $songs ?? [])->get();
        $album->songs()->saveMany($songs);
    }

    
    /**
     * Handle the Album "deleting" event.
     *
     * @param  \App\Models\Album  $album
     * @return void
     */
    public function deleting(Album $album)
    {
        if($album->image) {
            $album->image->delete();
        }
        $songs = $album->songs;
        foreach($songs as $song) {
            $song->delete();
        }
        $album->tags()->detach();
        $album->likes()->detach();
    }
}
