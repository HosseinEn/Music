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
    Route::get('/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
    Route::resource('artists', \App\Http\Controllers\Admin\ArtistController::class);
    Route::resource('albums' , \App\Http\Controllers\Admin\AlbumController::class);
    Route::post('/albums/song/delete',
        [\App\Http\Controllers\Admin\AlbumController::class, 'deleteSongFromAlbum'])->name('album.song.delete');
    Route::resource('songs', \App\Http\Controllers\Admin\SongController::class);
    Route::get('/song/{song}/download', [SongFileAccessController::class, "downloadSongFile"])->name('admin.download.song');
});


Route::get('/', function() {
    return view('main.index');
})->name('home');
