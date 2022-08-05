<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Models\Artist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class ArtistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = Artist::withCount('albums')->get();
        return view('artists.index', ['artists'=>$artists]);
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
        Artist::create($validatedData);
        return redirect(route('artists.index'))->with('success','هنرمند با موفقیت ایجاد گردید!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        return view('artists.show', ['artist'=>$artist]);
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
        if($request->slug_based_on_name) {
            $slugBase = $request->name;
        }
        else {
            $slugBase = $request->slug;
        }
        $slug = SlugService::createSlug(Artist::class, 'slug', $slugBase, ["unique"=>false]);
        $request->merge(["slug"=>$slug]);
        $request->validate([
            'slug' => [
                Rule::unique('artists')->ignore($artist->id),
            ],
        ], [
            'slug.unique' => 'اسلاگ قبلا استفاده شده است!'
        ]);

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
        //
    }
}
