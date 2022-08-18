<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        return view('front.main.allContent', [
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
        return view('front.albums.albums',[
            "albums"=>$albums
        ]);
    }

    public function showAlbum(Album $album) {
        return view('front.albums.album', ["album"=>$album]);
    }

    public function artists() {
        $artists = Artist::with(["image"])->paginate(20);
        return view('front.artists.artists',[
            "artists"=>$artists
        ]);
    }

    public function showArtist($artistSlug) {
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

    public function songs() {
        $songs = Song::with(["artist", "tags", "image"])            
            ->soloSongs()
            ->orderBy("released_date", "desc")
            ->published()
            ->paginate(20);
        return view('front.songs.songs', [
            "songs"=>$songs
        ]);  
    }

    public function showSong(Song $song) {
        return view('front.songs.song', ["song"=>$song]);
    }

    public function tags(Request $request, Tag $tag) {
        $show = $request->has("show") ? $request->query("show") : "songs";
        $items = [];
        if($show == "albums") {
            $items = $tag->albums()->with(["image", "artist", "tags"])->orderBy("released_date", "desc")->paginate(20);
        }
        else if ($show == "songs") {
            $items = $tag->songs()->soloSongs()->with(["image", "artist", "tags"])->orderBy("released_date", "desc")->paginate(20);
        }

        $tags = Tag::get();
        return view('front.filtered_by_tags', [
            "items"=>$items,
            "tag"=>$tag,
            "tags"=>$tags
        ]);
    }

    public function downloadSong(Request $request, Song $song) {
        $quality = "";
        if($request->has('quality')) {
            $quality = $request->query("quality");
        }
        if($quality == "128" && $song->songFiles()->quality128Exists()) {
            $songFile = $song->songFiles()->get128File()->first();
            $songPath = $songFile->path;
        }
        else if ($quality == "320" && $song->songFiles()->quality320Exists()) {
            $songFile = $song->songFiles()->get320File()->first();
            $songPath = $songFile->path;
        }
        else {
            abort(404);
        }
        $downloadName = $song->artist->name . " - " . $song->name . " ({$quality}) " . "." . $songFile->extension;
        return Storage::download($songPath, $downloadName);
    }
}
