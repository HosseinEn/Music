<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $artistsCount = Artist::count();
        $usersCount = User::count();
        $songsCount = Song::count();
        $albumsCount = Album::count();
        return view('home', [
            "artistsCount" =>$artistsCount,
            "usersCount"=>$usersCount,
            "songsCount"=>$songsCount,
            "albumsCount"=>$albumsCount,
        ]);
    }

    public function controlNotification(Request $request) {
        dd($request->all());
        return redirect()->back()->with('success', "وضعیت اطلاع رسانی با موفقیت تغییر کرد!");
    }
}
