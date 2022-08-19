<?php

use App\Http\Controllers\Admin\SongFileAccessController;
use Illuminate\Support\Facades\Auth;
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
    // Route::get('counts', [HomeController::class, 'counts']);
    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
    Route::resource('artists', \App\Http\Controllers\Admin\ArtistController::class);
    Route::resource('albums' , \App\Http\Controllers\Admin\AlbumController::class);
    Route::resource('tags' , \App\Http\Controllers\Admin\TagController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(["create", "store"]);
    Route::post('/albums/song/delete',
        [\App\Http\Controllers\Admin\AlbumController::class, 'deleteSongFromAlbum'])->name('album.song.delete');
    Route::resource('songs', \App\Http\Controllers\Admin\SongController::class);
    Route::get('/song/{song}/download', [SongFileAccessController::class, "downloadSongFile"])->name('admin.download.song');
    Route::post('/notification', [App\Http\Controllers\Admin\HomeController::class, 'controlNotification'])->name('admin.notification');
});


Route::get('/', [App\Http\Controllers\HomeController::class, "index"])
    ->name('home');
Route::get('/tags/{tag}', [App\Http\Controllers\HomeController::class, "tags"])
    ->name('front.tags');
Route::get('/song/{song}/download', [App\Http\Controllers\HomeController::class, "downloadSong"])
    ->name('download.song');
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

