<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendLogToAdminEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\Tag;
use App\Models\User;
use App\Services\MoveSongBetweenDisksService;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
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
            $albums = Album::with(["user", "artist"])
                ->where('name', 'like', "%{$searchParam}%")
                ->orWhereHas('artist', function($query) use ($searchParam) {
                    return $query->where('name', 'like', "%{$searchParam}%");
                })
                ->paginate(self::PAGINATEDBY);
        }
        else {
            $albums = Album::with(["user", "artist"])->latest()->paginate(self::PAGINATEDBY);
        }
        return view('albums.index',
            [
                "albums"=>$albums,
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
        $artists = Artist::latest()->get();
        $songs = Song::soloSongs()->latest()->get();
        $tags = Tag::get();
        return view('albums.create',
            [
                "artists"=>$artists,
                "songs"=>$songs,
                "tags"=>$tags
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAlbumRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlbumRequest $request)
    {
        $request->merge([
            "duration" => $this->createDuration(),
            "user_id" => Auth::user()->id,
            "auto_publish" => $request->auto_publish ? true : false
        ]);
        $this->createSlug($request, Album::class);
        $album = Album::create($request->except([
            "duration_hours",
            "duration_minutes",
            "duration_seconds",
            "tags",
            "cover"
        ]));
        $this->addImageToModelAndStore($album, 'album', 'cover');
        $user = User::where('id', Auth::user()->id)->get()->first();
        event(new SendLogToAdminEmail($user, "album.create"));   
        return redirect(route('albums.index'))->with('success', 'آلبوم با موفقیت ایجاد شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        return view('albums.show', ["album"=>$album]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        $artists = Artist::latest()->get();
        $songs = Song::soloSongs()->latest()->get();
        $tags = Tag::get();
        return view('albums.edit',
            [
                "artists"=>$artists,
                "songs"=>$songs,
                "album"=>$album,
                "tags"=>$tags
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlbumRequest  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        $slugBase = $this->slugBasedOnNameOrUserInputIfNotNull($request);
        $slug = SlugService::createSlug(Album::class, 'slug', strtolower($slugBase), ["unique"=>false]);
        $request->merge([
             "slug"=>$slug,
             "auto_publish"=>$request->auto_publish ? true : false,
             "publish_date"=>$request->auto_publish ? $request->publish_date : null
        ]);
        $this->uniqueSlugOnUpdate($request, $album, 'albums');
        $this->handleImageOnUpdate($request, $album, 'album', 'cover');
        $album->tags()->sync(request()->tags);
        $album->update($request->all());
        $user = User::where('id', Auth::user()->id)->get()->first();
        event(new SendLogToAdminEmail($user, "album.update"));   
        return redirect(route('albums.index'))->with('success', 'اطلاعات آلبوم با موفقیت ویرایش شد!');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        // Model events
        $album->delete();
        $user = User::where('id', Auth::user()->id)->get()->first();
        event(new SendLogToAdminEmail($user, "album.delete"));   
        return redirect()->back()->with('success', 'آلبوم  همراه با موسیقی ها با موفقیت حذف گردیدند!');
    }

    public function deleteSongFromAlbum(Request $request) {
        $song  = Song::findOrFail($request->song_id);
        $song->album_id = null;
        $song->published = false;
        $song->auto_publish = false;
        $song->publish_date = null;
        $song->save();
        return redirect()->back()->with('success', 'موسیقی با موفقیت از آلبوم حذف شد!');
    }
}
