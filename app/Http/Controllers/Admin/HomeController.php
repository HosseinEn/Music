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
    public function index()
    {
        return view('home');
    }

    public function counts() {
        $artistsCount = Artist::count();
        $usersCount = User::count();
        $songsCount = Song::count();
        $albumsCount = Album::count();
        return response()->json([
            "artistsCount" =>$artistsCount,
            "usersCount"=>$usersCount,
            "songsCount"=>$songsCount,
            "albumsCount"=>$albumsCount
        ]);
    }
}
