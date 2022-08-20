<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request) {
        if($request->has("query") && $request->get("query") != null) {
            $searchParam = $request->get("query");
            $albums = Album::with(["image", "artist"])->where('name', 'like', "%{$searchParam}%")
                                  ->published()
                                  ->get();
            $songs = Song::with(["image", "artist"])->where('name', 'like', "%{$searchParam}%")
                                  ->published()
                                  ->get();
            $artists = Artist::with(["image"])->where('name', 'like', "%{$searchParam}%")->get();
            $searchResults = $artists->merge($albums->merge($songs));
            return view('front.searchResult', compact("searchResults"));
        }
        else {
            return redirect(route('home'));
        }
    }
}
