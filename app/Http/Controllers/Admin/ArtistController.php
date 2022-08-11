<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Models\Artist;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class ArtistController extends Controller
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
            $artists = Artist::with("user")
                ->where('name', 'like', "%{$searchParam}%")->paginate(self::PAGINATEDBY);
        }
        else {
            $artists = Artist::with("user")->withCount('albums')->latest()->paginate(self::PAGINATEDBY);
        }
        return view('artists.index',
            ['artists'=>$artists,
            'pageNumMultiplyPageNum'=>$pageNumMultiplyPageNum]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('artists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArtistRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData["user_id"] = Auth::user()->id;
        $this->createSlug($validatedData);
        $artist = Artist::create($validatedData);
        if($request->has('image')) {
            $this->addImageToModelAndStore($request, $artist, 'artist', 'image');
        }
        return redirect(route('artists.index'))->with('success','هنرمند با موفقیت ایجاد گردید!');
    }

    public function createSlug(& $validatedData) {
        if(!isset($validatedData["slug"])) {
            $slugBase = $validatedData["name"];
        }
        else {
            $slugBase = $validatedData["slug"];
        }
        $slug = SlugService::createSlug(Artist::class, 'slug', strtolower($slugBase));
        $validatedData["slug"] = $slug;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
//        dd($artist->soloSongs()->get());
        return view('artists.show',
            ['artist'=>$artist,
             'albums'=> $artist->albums,
             'soloSongs' => $artist->soloSongs()->get()
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function edit(Artist $artist)
    {
        return view('artists.edit', ['artist'=>$artist]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArtistRequest  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArtistRequest $request, Artist $artist)
    {
        $slugBase = $this->slugBasedOnNameOrUserInputIfNotNull($request);
        $slug = SlugService::createSlug(Artist::class, 'slug', strtolower($slugBase), ["unique"=>false]);
        $request->merge(["slug"=>$slug]);
        $this->uniqueSlugOnUpdate($request, $artist, 'artists');
        $this->handleImageOnUpdate($request, $artist, 'artist', 'image');
        $artist->update($request->all());
        return redirect(route('artists.index'))->with('success', 'اطلاعات هنرمند با موفقیت ویرایش شد!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        if($artist->image) {
            Storage::delete($artist->image->path);
        }
        $artist->image()->delete();
        $artist->delete();
        return redirect()->back()->with('success', 'هنرمند با موفقیت حذف شد!');
    }
}
