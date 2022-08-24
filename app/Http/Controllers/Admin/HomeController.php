<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\NotifyAdmin;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $artistsCount = Artist::count();
        $usersCount = User::count();
        $songsCount = Song::count();
        $albumsCount = Album::count();
        $adminNotifies = NotifyAdmin::where("user_id", Auth::user()->id)->first();
        return view('home', [
            "artistsCount" =>$artistsCount,
            "usersCount"=>$usersCount,
            "songsCount"=>$songsCount,
            "albumsCount"=>$albumsCount,
            "adminNotifies"=>$adminNotifies
        ]);
    }

    public function controlNotification(Request $request) 
    {
        
        $request->merge(["user_id"=>Auth::user()->id]);
        $notifyAdmin = NotifyAdmin::where('user_id', Auth::user()->id)->get()->first();    
        if($notifyAdmin != null) {
            $notifyAdmin->update([
                "user_id"=>Auth::user()->id,    
                "crud_on_songs"=>$request->crud_on_songs ? true : false,
                "crud_on_albums"=>$request->crud_on_albums ? true : false,
                "crud_on_tags"=>$request->crud_on_tags ? true : false,
                "crud_on_users"=>$request->crud_on_users ? true : false,
                "crud_on_artists"=>$request->crud_on_artists ? true : false
            ]);
        }
        else {
            $notifyAdmin = NotifyAdmin::create($request->except("_token"));
        }
        // NotifyAdmin::updateOrCreate([
        //     "user_id"=>Auth::user()->id,
        //     "crud_on_songs"=>$request->crud_on_songs ? true : false,
        //     "crud_on_albums"=>$request->crud_on_albums ? true : false,
        //     "crud_on_tags"=>$request->crud_on_tags ? true : false,
        //     "crud_on_users"=>$request->crud_on_users ? true : false,
        //     "crud_on_artists"=>$request->crud_on_artists ? true : false,
        // ]);
        return redirect()->back()->with('success', "وضعیت اطلاع رسانی با موفقیت تغییر کرد!");
    }
}
