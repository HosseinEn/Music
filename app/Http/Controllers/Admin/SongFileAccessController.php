<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongFileAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function downloadSongFile(Request $request, Song $song) {
        $quality = "";
        if($request->has('quality')) {
            $quality = $request->query("quality");
        }
        if($quality == "128" && $song->songFiles()->quality128Exists()) {
            $songFile = $song->songFiles()->get128File()->first();
            $songPath = $songFile->path;
        }
        else if ($quality == "320" && $song->songFiles()->quality320Exists()) {
            $songFile = $song->songFiles()->get320File()->first();
            $songPath = $songFile->path;
        }
        else {
            abort(404);
        }
        $downloadName = $song->artist->name . " - " . $song->name . " ({$quality}) " . "." . $songFile->extension;
        return Storage::download($songPath, $downloadName);
    }
}
