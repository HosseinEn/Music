<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // TODO Order by created_date in likeable table
        $user = User::findOrFail(Auth::user()->id);
        $artists = $user->likedArtists;
        $albums = $user->likedAlbums;
        $songs = $user->likedSongs;
        return view('front.favorites.userFavorites', compact(["artists", "albums", "songs"]));
    }

    public function addArtistToFavorite(Artist $artist)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->likedArtists()->attach($artist);
        return redirect(route('user.favorites'))->with('success', 'هنرمند با موفقیت به لیست علاقه مندی های شما اضافه شد!');
    }

    public function addAlbumToFavorite(Album $album)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->likedAlbums()->attach($album);
        return redirect(route('user.favorites'))->with('success', 'آلبوم با موفقیت به لیست علاقه مندی های شما اضافه شد!');
    }

    public function addSongToFavorite(Song $song)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->likedSongs()->attach($song);
        return redirect(route('user.favorites'))->with('success', 'موسیقی با موفقیت به لیست علاقه مندی های شما اضافه شد!');
    }

    public function removeArtistFromFavorite(Artist $artist) 
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->likedArtists()->detach($artist);
        return redirect(route('user.favorites'))->with('success', 'هنرمند با موفقیت از لیست علاقه مندی های شما حذف شد!');
    }

    public function removeAlbumFromFavorite(Album $album) {
        $user = User::findOrFail(Auth::user()->id);
        $user->likedAlbums()->detach($album);
        return redirect(route('user.favorites'))->with('success', 'آلبوم با موفقیت از لیست علاقه مندی های شما حذف شد!');
    }
    
    public function removeSongFromFavorite(Song $song) {
        $user = User::findOrFail(Auth::user()->id);
        $user->likedSongs()->detach($song);
        return redirect(route('user.favorites'))->with('success', 'موسیقی با موفقیت از لیست علاقه مندی های شما حذف شد!');
    }
}
