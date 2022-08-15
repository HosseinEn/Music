<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
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
            $tags = Tag::with("user")
                ->where('name', 'like', "%{$searchParam}%")->paginate(self::PAGINATEDBY);
        }
        else {
            $tags = Tag::with("user")->latest()->paginate(self::PAGINATEDBY);
        }
        return view('tags.index',
            ['tags'=>$tags,
            'pageNumMultiplyPageNum'=>$pageNumMultiplyPageNum]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData["user_id"] = Auth::user()->id;
        $this->createSlug($validatedData, Tag::class);
        $tag = Tag::create($validatedData);
        return redirect(route('tags.index'))->with('success','ژانر با موفقیت ایجاد گردید!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tags.edit', ["tag"=>$tag]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $slugBase = $this->slugBasedOnNameOrUserInputIfNotNull($request);
        $slug = SlugService::createSlug(Tag::class, 'slug', strtolower($slugBase), ["unique"=>false]);
        $request->merge(["slug"=>$slug]);
        $this->uniqueSlugOnUpdate($request, $tag, 'tags');
        $tag->update($request->all());
        return redirect(route('tags.index'))->with('success', 'اطلاعات ژانر با موفقیت ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect(route('tags.index'))->with('success', "ژانر با موفقیت ایجاد شد!");
    }
}
