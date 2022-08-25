<?php

namespace App\Services;

use App\Models\Song;
use App\Models\SongFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongCreateUpdateAndUploadService {

    private $request;
    private $song;
    private $dateAndTime;
    private $extension;
    private const FILE_128_UPLOAD_UNPUBLISHED_PATH = "/unpublished_song_files/128";
    private const FILE_320_UPLOAD_UNPUBLISHED_PATH = "/unpublished_song_files/320";
    private const FILE_128_UPLOAD_PUBLISHED_PATH = "public/published_song_files/128";
    private const FILE_320_UPLOAD_PUBLISHED_PATH = "public/published_song_files/320";

    public function validateSongFileAndStore($request, $validatedData) {
        $this->request = $request;
        $quality = (string) $request->quality;
        if($quality == "128_320") {
            $this->validateFile("128");
            $this->validateFile("320");
            $this->song = Song::create($validatedData);
            $this->retrieveSongFileAndStoreAndCreateRelation("128");
            $this->retrieveSongFileAndStoreAndCreateRelation("320");
        }
        else if ($quality == "128" || $quality == "320"){
            $this->validateFile($quality);
            $this->song = Song::create($validatedData);
            $this->retrieveSongFileAndStoreAndCreateRelation($quality);
        }
        else {
            $this->throwQualityError();
        }
        return $this->song;
    }

    public function validateSongFileAndUpdate($request, $song) {
        $this->request = $request;
        $this->song = $song;
        $this->updateFileIfChanged("128");
        $this->updateFileIfChanged("320");
    }

    private function throwQualityError() {
        $error = \Illuminate\Validation\ValidationException::withMessages([
            'quality' => ['لطفا یک کیفیت معتبر از لیست انتخاب نمایید!'],
        ]);
        throw $error;
    } 

    private function validateFile(string $fileQuality) {
        if($this->getFileFromRequestByQuality($fileQuality)) {
            $this->request->validate([
                "song_file_{$fileQuality}"=>"mimes:mp3,mp4"
            ],
            [
                "song_file_{$fileQuality}.mimes" => "موسیقی باید از پسوندهای mp3 یا mp4 باشد!"
            ]);
        }
        else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                "song_file_{$fileQuality}" => ["یک فایل موسیقی با کیفیت {$fileQuality} برحسب کیفیت انتخاب شده باید  در این بخش آپلود گردد!"],
             ]);
             throw $error;
        }
    }

    private function retrieveSongFileAndStoreAndCreateRelation(string $fileQuality) {
        if($this->request->has("song_file_{$fileQuality}")) {
            $songFile = $this->request->file("song_file_{$fileQuality}");
            $path = $this->storeFileOnDisk($songFile, $fileQuality);
            $this->createRelation($path, $fileQuality);
        }
    }

    private function createRelation($path, $fileQuality) {
        $songFileModel = SongFile::make([
            "quality"=>$fileQuality,
            "duration"=>$this->request->duration,
            "path"=>$path,
            "extension"=>$this->extension
        ]);
        $this->song->songFiles()->save($songFileModel);
    }

    private function storeFileOnDisk($songFile, $fileQuality) {
        $this->dateAndTime = now()->format("Y-m-d_hmsu");
        $this->extension =  $songFile->guessClientExtension();
        if($this->songHasBeenPublished()) {
            $path = $this->storePublishedFileOnDisk($fileQuality, $songFile);
        }
        else {
            $path = $this->storeUnpublishedFileOnDisk($fileQuality, $songFile);
        }
        return $path;
    }

    private function songHasBeenPublished() {
        return $this->request->published;
    }

    private function storePublishedFileOnDisk($fileQuality, $songFile) {
        $path = $songFile->storeAs($this->getPublishedFilePathByQuality($fileQuality),
        "{$this->song->slug}_{$this->song->artist->name}_{$fileQuality}kbps_{$this->dateAndTime}.{$this->extension}");
        return $path;
    }
    
    private function storeUnpublishedFileOnDisk($fileQuality, $songFile) {
        $path = $songFile->storeAs($this->getUnpublishedFilePathByQuality($fileQuality),
        "{$this->song->slug}_{$this->song->artist->name}_{$fileQuality}kbps_{$this->dateAndTime}.{$this->extension}");
        return $path;
    }

    private function updateFileIfChanged(string $fileQuality) {
        if($this->request->has("song_file_{$fileQuality}")) {
            $this->validateFile($fileQuality);      
            $path = $this->replaceSongFile($fileQuality);
            if($this->songFileExists($fileQuality)) {
                $this->song->songFiles()->where("quality", $fileQuality)->update([
                    "duration"=>$this->request->duration,
                    "path"=>$path
                ]); 
            }
            else {
                $this->createRelation($path, $fileQuality);
            }
        }
    }

    private function replaceSongFile($fileQuality) {
        $oldSongPath = $this->getOldStoredFilePathByQuality($fileQuality);
        Storage::delete($oldSongPath);
        $songFile = $this->request->file("song_file_{$fileQuality}");
        $this->extension = $songFile->guessClientExtension();
        $this->dateAndTime = now()->format("Y-m-d_hmsu");
        if($this->songHasBeenPublished()) {
            $path = $this->storePublishedFileOnDisk($fileQuality, $songFile);
        }
        else {
            $path = $this->storeUnpublishedFileOnDisk($fileQuality, $songFile);
        }
        return $path;
    }

    private function songFileExists($fileQuality) {
        if($fileQuality == "128") {
            return $this->song->songFiles()->quality128Exists();
        }
        else if($fileQuality == "320") {
            return $this->song->songFiles()->quality320Exists();
        }
    }

    private function getFileFromRequestByQuality(string $fileQuality) {
        if($fileQuality == "128") {
            return $this->request->song_file_128;
        }
        else if($fileQuality == "320") {
            return $this->request->song_file_320;
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

    private function getOldStoredFilePathByQuality(string $fileQuality)  {
        if($fileQuality == "128") {
            return $this->song->songFiles()->quality128Path();
        }
        else if($fileQuality == "320") {
            return $this->song->songFiles()->quality320Path();
        }
    }


}