<?php

use App\Http\Controllers\ArtistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/admin/home', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

Route::resource('artists', ArtistController::class);

Route::get('/', function() {
    return view('index');
});