<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendContactUsRequest;
use App\Mail\ContactUs;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index() {

        $cachedLatestAlbum = Cache::remember("latestAlbums", 10, function() {
            return Album::with(["songs", "songs.artist", "artist", "tags", "image", "songs.songFiles"])
                ->orderBy("released_date", "desc")
                ->published()
                ->get()
                ->take(3);
        });

        $cachedPopularAlbums = Cache::remember("popularAlbums", 10, function() {
            return Album::withCount('likes')
                ->with(["songs", "songs.artist", "artist", "tags", "image", "songs.songFiles"])
                ->orderBy('likes_count', 'desc')
                ->published()
                ->get()
                ->take(3);
        });

        $cachedSoloSongs = Cache::remember("soloSongs", 10, function() {
            return Song::with(["artist", "tags", "image"])            
                ->soloSongs()
                ->orderBy("released_date", "desc")
                ->published()
                ->get()
                ->take(9);
        });

        $cachedPopularSongs = Cache::remember("popularSongs", 10, function() {
            return Song::withCount('likes')
                ->with(["artist", "tags", "image"])            
                ->soloSongs()
                ->orderBy("released_date", "desc")
                ->published()
                ->get()
                ->take(9);
        });

        $tags = Tag::get()->take(8);
        
        $artists = Artist::with(["image"])->get()->take(8);

        $banner = Song::with(["image", "artist"])->orderBy('released_date', 'desc')->published()->get()->take(7);

        return view('front.main.allContent', [
            "latestAlbums"=>$cachedLatestAlbum,
            "popularAlbums"=>$cachedPopularAlbums,
            "latestSongs"=>$cachedSoloSongs,
            "popularSongs"=>$cachedPopularSongs,
            "tags"=>$tags,
            "artists"=>$artists,
            "banner"=>$banner
        ]);
    }

    public function tags(Request $request, Tag $tag) {
        $show = $request->has("show") ? $request->query("show") : "songs";
        $items = [];
        if($show == "albums") {
            $items = $tag->albums()->with(["image", "artist", "tags"])->published()->orderBy("released_date", "desc")->paginate(20);
        }
        else if ($show == "songs") {
            $items = $tag->songs()->soloSongs()->with(["image", "artist", "tags"])->published()->orderBy("released_date", "desc")->paginate(20);
        }

        $tags = Tag::get();
        return view('front.filtered_by_tags', [
            "items"=>$items,
            "tag"=>$tag,
            "tags"=>$tags
        ]);
    }

    public function downloadSong(Request $request, $songSlug) {
        $song = Song::where('slug', $songSlug)->published()->firstOrFail();
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

    public function contactUs(SendContactUsRequest $request) {
        $users = User::isAdmin()->get();
        foreach($users as $user) {
            Mail::to($user)->send(new ContactUs($request->all()));
        }
        return redirect()->back()->with('success', 'پیام شما با موفقیت ارسال شد!');
    }
}
