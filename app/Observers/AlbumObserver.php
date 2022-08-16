<?php

namespace App\Observers;

use App\Models\Album;
use App\Models\Song;
use App\Services\MoveSongBetweenDisksService;

class AlbumObserver
{
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
        $this->changeStatusOfRelatedSongs($album);
    }


    public function changeStatusOfRelatedSongs($album) {
        $songs = $album->songs;
        $moveSongs = new MoveSongBetweenDisksService();
        foreach($songs as $song) {
            $song->published = $album->published;
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
        $album->image->delete();
        $songs = $album->songs;
        foreach($songs as $song) {
            $song->delete();
        }
    }
}
