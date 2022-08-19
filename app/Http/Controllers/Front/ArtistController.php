<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = Artist::with(["image"])->paginate(20);
        return view('front.artists.artists',[
            "artists"=>$artists
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show($artistSlug)
    {
        $artist = Artist::where('slug', $artistSlug)
        ->with([
                "songs" => function($query) {
                    return $query->with(["tags", "image"])   
                                 ->soloSongs()
                                 ->published()
                                 ->orderBy("released_date", "desc");
                }, 
                "albums"=> function($query) {
                    return $query->with(["artist", "tags", "image"])
                                 ->orderBy("released_date", "desc")
                                 ->published();
                }, 
                "image"
        ])
        ->firstOrFail();
        return view('front.artists.artist', ["artist"=>$artist]);
    }
}
