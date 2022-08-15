<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $latestAlbums = Album::with(["songs", "artist", "tags", "image", "songs.songFiles"])
            ->orderBy("released_date", "desc")
            ->published()
            ->get()
            ->take(3);
        // dd($latestAlbums->toArray());
        $soloSongs = Song::with(["artist", "tags", "image"])            
        ->soloSongs()
        ->orderBy("released_date", "desc")
        ->published()
        ->get()
        ->take(9);

        $tags = Tag::get()->take(8);
        
        $artists = Artist::with(["image"])->get()->take(8);

        return view('main.all_content', [
            "latestAlbums"=>$latestAlbums,
            "latestSongs"=>$soloSongs,
            "tags"=>$tags,
            "artists"=>$artists
        ]);
    }

    public function albums() {
        $albums = Album::with(["songs", "artist", "tags", "image"])
            ->orderBy("released_date", "desc")
            ->published()
            ->paginate(20);
        return view('main.albums',[
            "albums"=>$albums
        ]);
    }

    public function songs() {
        $songs = Song::with(["artist", "tags", "image"])            
            ->soloSongs()
            ->orderBy("released_date", "desc")
            ->published()
            ->paginate(20);
        return view('main.songs', [
            "songs"=>$songs
        ]);  
    }

    public function tags(Request $request, Tag $tag) {
        $show = $request->has("show") ? $request->query("show") : "songs";
        $items = [];
        if($show == "albums") {
            $items = $tag->albums()->orderBy("released_date", "desc")->paginate(20);
        }
        else if ($show == "songs") {
            $items = $tag->songs()->soloSongs()->orderBy("released_date", "desc")->paginate(20);
        }

        $tags = Tag::get();
        return view('main.filtered_by_tags', [
            "items"=>$items,
            "tag"=>$tag,
            "tags"=>$tags
        ]);
    }
}
