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
    Route::post('/albums/song/delete',
        [\App\Http\Controllers\Admin\AlbumController::class, 'deleteSongFromAlbum'])->name('album.song.delete');
    Route::resource('songs', \App\Http\Controllers\Admin\SongController::class);
    Route::get('/song/{song}/download', [SongFileAccessController::class, "downloadSongFile"])->name('admin.download.song');
});


Route::get('/', [App\Http\Controllers\HomeController::class, "index"])
    ->name('home');
Route::get('/albums', [App\Http\Controllers\HomeController::class, "albums"])
    ->name('front.albums');
Route::get('/songs', [App\Http\Controllers\HomeController::class, "songs"])
    ->name('front.songs');  
Route::get('/tags/{tag}', [App\Http\Controllers\HomeController::class, "tags"])
    ->name('front.tags');
Route::get('/song/{song}', [App\Http\Controllers\HomeController::class, "showSong"])
    ->name('show.song');
    Route::get('/song/{song}/download', [App\Http\Controllers\HomeController::class, "downloadSong"])
->name('download.song');
