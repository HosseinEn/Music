<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Tag;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    private const PAGINATEDBY = 10;

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageNumMultiplyPageNum = $this->calculateCounter($request->query('page'));
        if($request->has('search')) {
            $searchParam = $request->get('search');
            $songs = Song::with(["user", "artist"])
                ->where('name', 'like', "%{$searchParam}%")->paginate(self::PAGINATEDBY);
        }
        else {
            $songs = Song::with(["user", "artist"])->latest()->paginate(self::PAGINATEDBY);
        }
        return view('songs.index',
            [
                "songs"=>$songs,
                "pageNumMultiplyPageNum"=>$pageNumMultiplyPageNum
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::get();
        $artists = Artist::get();
        return view('songs.create', ["tags"=>$tags, "artists"=>$artists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSongRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSongRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData["user_id"] = Auth::user()->id;
        $validatedData["quality"] = $request->quality;
        $validatedData["duration"] = $this->createDuration($validatedData);
        $this->createSlug($validatedData, Artist::class);
        $song = Song::create($validatedData);
        if($request->has('cover')) {
            $this->addImageToModelAndStore($request, $song, 'song', 'cover');
        }    
        $song->tags()->attach($request->tags);
        return redirect(route('songs.index'))->with('success','موسیقی با موفقیت ایجاد گردید!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        return view('songs.show', ["song"=>$song]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSongRequest  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSongRequest $request, Song $song)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        if($song->image) {
            $imagePath = $song->image->path;
            Storage::delete($imagePath);
        }
        $song->image()->delete();
        $song->delete();
        return redirect()->back()->with('success', 'موسیقی با موفقیت حذف گردید!');
    }
}
