<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class MoveSongBetweenDisksService {

    private $song;

    private const FILE_128_UPLOAD_UNPUBLISHED_PATH = "/unpublished_song_files/128";
    private const FILE_320_UPLOAD_UNPUBLISHED_PATH = "/unpublished_song_files/320";
    private const FILE_128_UPLOAD_PUBLISHED_PATH = "/public/published_song_files/128";
    private const FILE_320_UPLOAD_PUBLISHED_PATH = "/public/published_song_files/320";


    public function moveSongBetweenDisksAndUpdatePath($song) {
        $this->song = $song;
        if($this->songHasBeenPublished()) {
            $this->moveFileTo("public");
        }
        else {
            $this->moveFileTo("private");
        }
    }

    private function moveFileTo($to) {
        if($this->song->songFiles()->quality128Exists()) {
            $songPath = $this->getOldStoredFilePathByQuality("128");
            $newPath = $this->generateNewPathForMovedFile("128", $to);
            Storage::move($songPath, $newPath);
            $this->song->songFiles()->where("quality", 128)->update([
                "path"=>$newPath
            ]);
        }
        if($this->song->songFiles()->quality320Exists()) {
            $songPath = $this->getOldStoredFilePathByQuality("320");
            $newPath = $this->generateNewPathForMovedFile("320", $to);
            Storage::move($songPath, $newPath);
            $this->song->songFiles()->where("quality", 320)->update([
                "path"=>$newPath
            ]);
        }
    }

    private function generateNewPathForMovedFile($fileQuality, $to) {
        $dateAndTime = now()->format("Y-m-d_hmsu");
        if($fileQuality == "128") {
            $extension = $this->song->songFiles()->get128File()->first()->extension;
        }
        else {
            $extension = $this->song->songFiles()->get320File()->first()->extension;
        }
        if($to == "public") {
            return $this->getPublishedFilePathByQuality($fileQuality) .
                "/". "song_{$this->song->id}_{$fileQuality}kbps_{$dateAndTime}.{$extension}";
        }
        else {
            return $this->getUnpublishedFilePathByQuality($fileQuality) .
            "/". "song_{$this->song->id}_{$fileQuality}kbps_{$dateAndTime}.{$extension}";
        }
    }

    private function songHasBeenPublished() {
        return $this->song->published;
    }

    private function getOldStoredFilePathByQuality(string $fileQuality)  {
        if($fileQuality == "128") {
            return $this->song->songFiles()->quality128Path();
        }
        else if($fileQuality == "320") {
            return $this->song->songFiles()->quality320Path();
        }
    }

    private function getPublishedFilePathByQuality(string $fileQuality) {
        if($fileQuality == "128") {
            return self::FILE_128_UPLOAD_PUBLISHED_PATH;
        }
        else if($fileQuality == "320") {
            return self::FILE_320_UPLOAD_PUBLISHED_PATH;
        }
    }

    private function getUnpublishedFilePathByQuality(string $fileQuality) {
        if($fileQuality == "128") {
            return self::FILE_128_UPLOAD_UNPUBLISHED_PATH;
        }
        else if($fileQuality == "320") {
            return self::FILE_320_UPLOAD_UNPUBLISHED_PATH;
        }
    }
}