<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = Song::with(["artist", "tags", "image"])            
        ->soloSongs()
        ->orderBy("released_date", "desc")
        ->published()
        ->paginate(20);
        return view('front.songs.songs', [
            "songs"=>$songs
        ]);  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show($songSlug)
    {
        $song = Song::where('slug', $songSlug)->published()->firstOrFail();
        return view('front.songs.song', ["song"=>$song]);
    }
}
