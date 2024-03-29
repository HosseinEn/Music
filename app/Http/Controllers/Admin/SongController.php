<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendLogToAdminEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Tag;
use App\Models\User;
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
        $pageNumberMultiplyPaginationSize = $this->calculateCounter($request->query('page'));
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
                "pageNumberMultiplyPaginationSize"=>$pageNumberMultiplyPaginationSize
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
    public function store(StoreSongRequest $request, SongCreateUpdateAndUploadService $songValidateAndCreate)
    {
        $request->merge([
            "duration" => $this->createDuration(),
            "user_id" => Auth::user()->id,
            "auto_publish" => $request->auto_publish ? true : false
        ]);
        $this->createSlug($request, Song::class);
        $song = $songValidateAndCreate->validateSongFileAndStore($request);
        $this->addSongToAlbum($song, $request->album);
        $this->addImageToModelAndStore($song, 'song', 'cover');
        $song->tags()->attach($request->tags);
        $user = User::where('id', Auth::user()->id)->get()->first();
        event(new SendLogToAdminEmail($user, "song.create"));  
        return redirect(route('songs.index'))->with('success','موسیقی با موفقیت ایجاد گردید!');
    }

    public function addSongToAlbum($song, $album_id) {
        if(isset($album_id)) {
            $album = Album::findOrFail($album_id);
            $song->album()->associate($album);
            $song->published = $album->published;
            $song->auto_publish = $album->auto_publish;
            $song->publish_date = $album->publish_date;
            $song->save();
        }
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
        SongCreateUpdateAndUploadService $songUpload)
    {
        $slugBase = $this->slugBasedOnNameOrUserInputIfNotNull($request);
        $slug = SlugService::createSlug(Song::class, 'slug', strtolower($slugBase), ["unique"=>false]);
        $request->merge([
            "slug"=>$slug,
            "auto_publish"=>$request->auto_publish ? true : false,
            "publish_date"=>$request->auto_publish ? $request->publish_date : null
        ]);
        $this->uniqueSlugOnUpdate($request, $song, 'songs');
        $this->handleImageOnUpdate($request, $song, 'song', 'cover');
        $songUpload->validateSongFileAndUpdate($request, $song);
        $song->tags()->sync($request->tags);
        $song->update($request->all());
        if(isset($request->album)) {
            $this->addSongToAlbum($song, $request->album);
        }
        else {
            $song->album()->disassociate();
            $song->save();
        }
        $user = User::where('id', Auth::user()->id)->get()->first();
        event(new SendLogToAdminEmail($user, "song.update"));
        return redirect(route('songs.index'))->with('success', 'اطلاعات آهنگ با موفقیت ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        // Model events
        $song->delete();
        $user = User::where('id', Auth::user()->id)->get()->first();
        event(new SendLogToAdminEmail($user, "song.delete"));   
        return redirect()->back()->with('success', 'موسیقی با موفقیت حذف گردید!');
    }
}
