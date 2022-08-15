<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Tag;
use App\Services\MoveSongBetweenDisksService;
use App\Services\SongCreateUpdateAndUploadService;
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
            $songs = Song::with(["user", "artist", "songFiles", "album"])
                ->where('name', 'like', "%{$searchParam}%")
                ->orWhereHas('album', function($query) use ($searchParam) {
                    return $query->where('name', 'like', "%{$searchParam}%");
                })
                ->orWhereHas('artist', function($query) use ($searchParam) {
                    return $query->where('name', 'like', "%{$searchParam}%");
                })
                ->paginate(self::PAGINATEDBY);
        }
        else {
            $songs = Song::with(["user", "artist", "songFiles", "album"])
                ->latest()->paginate(self::PAGINATEDBY);
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
        $albums = Album::get();
        return view('songs.create', 
            [
                "tags"=>$tags, 
                "artists"=>$artists,
                "albums"=>$albums
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSongRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSongRequest $request, SongCreateUpdateAndUploadService $songUploadAndCreate)
    {
        $validatedData = $request->validated();
        $validatedData["user_id"] = Auth::user()->id;
        $validatedData["published"] = $request->published;
        $duration = $this->createDuration($validatedData);
        $request->merge(["duration"=>$duration]);
        $this->createSlug($validatedData, Song::class);
        $song = $songUploadAndCreate->validateSongFileAndStore($request, $validatedData);
        if(isset($request->album)) {
            $this->addSongToAlbum($song, $request->album);
        }
        if($request->has('cover')) {
            $this->addImageToModelAndStore($request, $song, 'song', 'cover');
        }    
        $song->tags()->attach($request->tags);
        return redirect(route('songs.index'))->with('success','موسیقی با موفقیت ایجاد گردید!');
    }

    public function addSongToAlbum($song, $album_id) {
        $album = Album::findOrFail($album_id);
        $song->album()->associate($album);
        $song->save();
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
        $tags = Tag::get();
        $artists = Artist::get();
        $albums = Album::get();
        return view('songs.edit', 
            [
                "tags"=>$tags, 
                "artists"=>$artists,
                "albums"=>$albums,
                "song"=>$song
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSongRequest  $request
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSongRequest $request, Song $song, 
        SongCreateUpdateAndUploadService $songUpload, MoveSongBetweenDisksService $moveSong)
    {
        $slugBase = $this->slugBasedOnNameOrUserInputIfNotNull($request);
        $slug = SlugService::createSlug(Song::class, 'slug', strtolower($slugBase), ["unique"=>false]);
        $request->merge(["slug"=>$slug]);
        $this->uniqueSlugOnUpdate($request, $song, 'songs');
        $this->handleImageOnUpdate($request, $song, 'song', 'cover');
        if(isset($request->album)) {
            $this->addSongToAlbum($song, $request->album);
        }
        $songUpload->validateSongFileAndUpdate($request, $song);
        $song->tags()->sync($request->tags);
        $songBeforeUpdate = $song;
        $song->update($request->all());
        if($this->songStatusChanged($request, $songBeforeUpdate)) {
            $moveSong->moveSongBetweenDisksAndUpdatePath($song);
        }
        return redirect(route('songs.index'))->with('success', 'اطلاعات آهنگ با موفقیت ویرایش شد!');
    }

    public function songStatusChanged($request, $song) {
        return $request->published != $song->published;
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
        if($song->songFiles) {
            $song128Path = $song->songFiles()->quality128Path();
            $song320Path = $song->songFiles()->quality320Path();
            Storage::delete($song128Path);
            Storage::delete($song320Path); 
        }
        $song->image()->delete();
        $song->delete();
        return redirect()->back()->with('success', 'موسیقی با موفقیت حذف گردید!');
    }
}