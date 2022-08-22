<?php

use App\Http\Controllers\Admin\SongFileAccessController;
use App\Mail\ContactUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::prefix('admin')->middleware('is_admin')->group(function() {
    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
    Route::resource('artists', \App\Http\Controllers\Admin\ArtistController::class);
    Route::resource('albums' , \App\Http\Controllers\Admin\AlbumController::class);
    Route::resource('tags' , \App\Http\Controllers\Admin\TagController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(["create", "store"]);
    Route::post('/albums/song/delete',
        [\App\Http\Controllers\Admin\AlbumController::class, 'deleteSongFromAlbum'])->name('album.song.delete');
    Route::resource('songs', \App\Http\Controllers\Admin\SongController::class);
    Route::get('/song/{song}/download', [SongFileAccessController::class, "downloadSongFile"])->name('admin.download.song');
    Route::post('/notification', [App\Http\Controllers\Admin\HomeController::class, 'controlNotification'])
        ->name('admin.notification');
});

Route::controller(App\Http\Controllers\HomeController::class)->group(function() {
    Route::get('/', "index")->name('home');
    Route::get('/tags/{tag}', "tags")->name('front.tags');
    Route::get('/song/{song}/download', "downloadSong")->name('download.song')->middleware("throttle:5, 1");
    Route::post('/contact', "contactUs")->name('contact');
});

Route::controller(App\Http\Controllers\Front\LikeController::class)->group(function() {
    Route::get('/liked',  "index")->name('user.favorites');

    Route::post('/artist/{artist}/liked',  "addArtistToFavorite")->name('user.liked.artist');
    Route::post('/album/{album}/liked',  "addAlbumToFavorite")->name('user.liked.album');
    Route::post('/song/{song}/liked',  "addSongToFavorite")->name('user.liked.song');
        
    Route::post('/album/{album}/delete/liked',  "removeAlbumFromFavorite")->name('user.removed.liked.album');
    Route::post('/artist/{artist}/delete/liked',  "removeArtistFromFavorite")->name('user.removed.liked.artist');
    Route::post('/song/{song}/delete/liked',  "removeSongFromFavorite")->name('user.removed.liked.song');
});

 

Route::get('/albums', [App\Http\Controllers\Front\AlbumController::class, "index"])
    ->name('front.albums');
Route::get('/album/{album}', [App\Http\Controllers\Front\AlbumController::class, "show"])
    ->name('show.album');

Route::get('/artists', [App\Http\Controllers\Front\ArtistController::class, "index"])
    ->name('front.artists');
Route::get('/artist/{artist}', [App\Http\Controllers\Front\ArtistController::class, "show"])
    ->name('show.artist');

Route::get('/songs', [App\Http\Controllers\Front\SongController::class, "index"])
    ->name('front.songs');  
Route::get('/song/{song}', [App\Http\Controllers\Front\SongController::class, "show"])
    ->name('show.song');
Route::get('/search', [App\Http\Controllers\Front\SearchController::class, "search"])
    ->name("search");

