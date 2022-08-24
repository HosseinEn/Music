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
    public function index(Request $request)
    {
        $order = "released_date";

        if($request->has("order") && $request->query("order") === "popular") {
            $order = "likes_count";
        }

        $songs = Song::withCount('likes')->with(["artist", "tags", "image"])            
        ->soloSongs()
        ->orderBy($order, "desc")
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
