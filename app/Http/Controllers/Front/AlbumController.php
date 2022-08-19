<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::with(["songs", "artist", "tags", "image"])
        ->orderBy("released_date", "desc")
        ->published()
        ->paginate(20);

        return view('front.albums.albums',[
            "albums"=>$albums
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show($albumSlug)
    {
        $album = Album::where('slug', $albumSlug)->published()->firstOrFail();
        return view('front.albums.album', ["album"=>$album]);
    }
}
