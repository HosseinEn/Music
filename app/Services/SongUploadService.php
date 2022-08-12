<?php

namespace App\Services;

use App\Models\SongFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SongUploadService {

    private $request;
    private $song;
    private $dateAndTime;
    private $extension;
    private const FILE_128_UPLOAD_UNPUBLISHED_PATH = "/unpublished_song_files/128";
    private const FILE_320_UPLOAD_UNPUBLISHED_PATH = "/unpublished_song_files/320";
    private const FILE_128_UPLOAD_PUBLISHED_PATH = "/public/published_song_files/128";
    private const FILE_320_UPLOAD_PUBLISHED_PATH = "/public/published_song_files/320";

    public function validateSongFileAndStore($request, $song) {
        $this->request = $request;
        $this->song = $song; 
        $quality = (string) $request->quality;
        if($quality == "128_320") {
            if($this->request->method() == 'POST') {
                $this->validateFile("128");
                $this->validateFile("320");
                $this->retrieveSongFileAndStoreAndCreateRelation("128");
                $this->retrieveSongFileAndStoreAndCreateRelation("320");
            }
            else if($this->request->method() == 'PUT'){
                $this->updateFileIfChanged("128");
                $this->updateFileIfChanged("320");
            }
        }
        else {
            if($this->request->method() == 'POST') {
                $this->validateFile($quality);
                $this->retrieveSongFileAndStoreAndCreateRelation($quality);
            }
            else if ($this->request->method() == 'PUT') {
                $this->updateFileIfChanged($quality);
            }
        }
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

    public function createRelation($path, $fileQuality) {
        $songFileModel = SongFile::make([
            "quality"=>$fileQuality,
            "duration"=>$this->request->duration,
            "path"=>$path
        ]);
        $this->song->songFiles()->save($songFileModel);
    }

    public function storeFileOnDisk($songFile, $fileQuality) {
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
        "song_{$this->song->id}_{$fileQuality}kbps_{$this->dateAndTime}.{$this->extension}");
        return $path;
    }
    
    private function storeUnpublishedFileOnDisk($fileQuality, $songFile) {
        $path = $songFile->storeAs($this->getUnpublishedFilePathByQuality($fileQuality),
        "song_{$this->song->id}_{$fileQuality}kbps_{$this->dateAndTime}.{$this->extension}");
        return $path;
    }

    private function updateFileIfChanged(string $fileQuality) {
        if($this->request->has("song_file_{$fileQuality}")) {
            $this->validateFile($fileQuality);      
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
            $this->song->songFiles()->where("quality", $fileQuality)->update([
                "duration"=>$this->request->duration,
                "path"=>$path
            ]);            
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

















    // switch($quality) {
    //     case "128":
    //         if($this->request->method() == 'POST') {
    //             // $this->validate128File();
    //             // $this->store128File();
    //             $this->validateFile("128");
    //             $this->storeFile("128");
    //         }
    //         else if($this->request->method() == 'PUT'){
    //             // $this->update128FileIfChanged();
    //             $this->updateFileIfChanged("128");
    //         }
    //     break;
    //     case "320":
    //         if($this->request->method() == 'POST') {
    //             // $this->validate320File();
    //             // $this->store320File();
    //             $this->validateFile("320");
    //             $this->storeFile("320");
    //         }
    //         else if($this->request->method() == 'PUT'){
    //             // $this->update320FileIfChanged();
    //             $this->updateFileIfChanged("320");
    //         }
    //     break;
    //     case "128_320":
    //         if($this->request->method() == 'POST') {
    //             // $this->validate128And320File();
    //             // $this->store128File();
    //             // $this->store320File();
    //             $this->validateFile("128");
    //             $this->validateFile("320");
    //             $this->storeFile("128");
    //             $this->storeFile("320");

    //         }
    //         else if($this->request->method() == 'PUT'){
    //             // $this->update128FileIfChanged();
    //             // $this->update320FileIfChanged();
    //             $this->updateFileIfChanged("128");
    //             $this->updateFileIfChanged("320");
    //         }
    //     break;  
    //     default:
    //         $error = \Illuminate\Validation\ValidationException::withMessages([
    //             'quality' => ['لطفا یک کیفیت معتبر از لیست انتخاب نمایید!'],
    //         ]);
    //         throw $error;
    // }



    // private function validate128File() {
    //     if($this->request->song_file_128) {
    //         $this->request->validate([
    //             "song_file_128"=>"mimes:mp3,mp4"
    //         ],
    //         [
    //             "song_file_128.mimes" => "موسیقی باید از پسوندهای mp3 یا mp4 باشد!"
    //         ]);
    //     }
    //     else {
    //         $error = \Illuminate\Validation\ValidationException::withMessages([
    //             'song_file_128' => ['یک فایل موسیقی با کیفیت ۱۲۸ برحسب کیفیت انتخاب شده باید  در این بخش آپلود گردد!'],
    //          ]);
    //          throw $error;
    //     }
    // }
    

    // private function validate320File() {
    //     if($this->request->song_file_320) {
    //         $this->request->validate([
    //             "song_file_320"=>"mimes:mp3,mp4"
    //         ],
    //         [
    //             "song_file_320.mimes" => "موسیقی باید از پسوندهای mp3 یا mp4 باشد!"
    //         ]);
    //     }
    //     else {
    //         $error = \Illuminate\Validation\ValidationException::withMessages([
    //             'song_file_320' => ['یک فایل موسیقی با کیفیت ۳۲۰ برحسب کیفیت انتخاب شده باید  در این بخش آپلود گردد!'],
    //          ]);
    //          throw $error;
    //     }
    // }

    // private function store128File() {
    //     $dateAndTime = now()->format("Y-m-d_hmsu");
    //     if($this->request->has('song_file_128')) {
    //         $songFile = $this->request->file('song_file_128');
    //         $extension = $songFile->guessClientExtension();
    //         if($this->request->published == true) {
    //             $path = $songFile->storeAs(self::FILE_128_UPLOAD_PUBLISHED_PATH,
    //                 "song_{$this->song->id}_128kbps_{$dateAndTime}.{$extension}");
    //         }
    //         else {
    //             $path = $songFile->storeAs(self::FILE_128_UPLOAD_UNPUBLISHED_PATH,
    //             "song_{$this->song->id}_128kbps_{$dateAndTime}.{$extension}");  
    //         }
    //         $songFileModel = SongFile::make([
    //             "quality"=>"128",
    //             "duration"=>$this->request->duration,
    //             "path"=>$path
    //         ]);
    //         $this->song->songFiles()->save($songFileModel);
    //     }
    // }

    // private function store320File() {
    //     $dateAndTime = now()->format("Y-m-d_hmsu");
    //     if($this->request->has('song_file_320')) {
    //         $songFile = $this->request->file('song_file_320');
    //         $extension = $songFile->guessClientExtension();
    //         if($this->request->published == true) {
    //             $path = $songFile->storeAs(self::FILE_320_UPLOAD_PUBLISHED_PATH,
    //             "song_{$this->song->id}_320kbps_{$dateAndTime}.{$extension}");

    //         }
    //         else {
    //             $path = $songFile->storeAs(self::FILE_320_UPLOAD_UNPUBLISHED_PATH,
    //             "song_{$this->song->id}_320kbps_{$dateAndTime}.{$extension}");
    //         }
    //         $songFileModel = SongFile::make([
    //             "quality"=>"320",
    //             "duration"=>$this->request->duration,
    //             "path"=>$path
    //         ]);
    //         $this->song->songFiles()->save($songFileModel);
    //     }
    // }


        // private function update128FileIfChanged() {
    //     if($this->request->has('song_file_128')) {
    //         $this->validate128File();
    //         $dateAndTime = now()->format("Y-m-d_hmsu");
    //         $oldImagePath = $this->song->songFiles()->quality128Path();
    //         Storage::delete($oldImagePath);
    //         $songFile = $this->request->file('song_file_128');
    //         /* another function */
    //         $extension = $songFile->guessClientExtension();
    //         if($this->request->published == true) {
    //             $path = $songFile->storeAs(self::FILE_128_UPLOAD_PUBLISHED_PATH,
    //                 "song_{$this->song->id}_128kbps_{$dateAndTime}.{$extension}");
    //         }
    //         else {
    //             $path = $songFile->storeAs(self::FILE_128_UPLOAD_UNPUBLISHED_PATH,
    //             "song_{$this->song->id}_128kbps_{$dateAndTime}.{$extension}");  
    //         }
    //         /* another function */
    //         $this->song->songFiles()->update([
    //             "duration"=>$this->request->duration,
    //             "path"=>$path
    //         ]);
    //     }
    // }

    // private function update320FileIfChanged() {
    //     if($this->request->has('song_file_320')) {
    //         $this->validate320File();
    //         $dateAndTime = now()->format("Y-m-d_hmsu");
    //         $oldImagePath = $this->song->songFiles()->quality320Path();
    //         Storage::delete($oldImagePath);
    //         $songFile = $this->request->file('song_file_320');
    //         /* another function */
    //         $extension = $songFile->guessClientExtension();
    //         if($this->request->published == true) {
    //             $path = $songFile->storeAs(self::FILE_320_UPLOAD_PUBLISHED_PATH,
    //             "song_{$this->song->id}_320kbps_{$dateAndTime}.{$extension}");

    //         }
    //         else {
    //             $path = $songFile->storeAs(self::FILE_320_UPLOAD_UNPUBLISHED_PATH,
    //             "song_{$this->song->id}_320kbps_{$dateAndTime}.{$extension}");
    //         }
    //         /* another function */
    //         $this->song->songFiles()->update([
    //             "duration"=>$this->request->duration,
    //             "path"=>$path
    //         ]);
    //     }
    // }

        // private function validate128And320File() {
    //     if($this->request->song_file_320) {
    //         $this->request->validate([
    //             "song_file_128"=>"mimes:mp3,mp4",
    //             "song_file_320"=>"mimes:mp3,mp4"
    //         ],
    //         [
    //             "song_file_128.mimes" => "موسیقی باید از پسوندهای mp3 یا mp4 باشد!",
    //             "song_file_320.mimes" => "موسیقی باید از پسوندهای mp3 یا mp4 باشد!"
    //         ]);
    //     }
    //     else {
    //         $error = \Illuminate\Validation\ValidationException::withMessages([
    //             'song_file_128' => ['یک فایل موسیقی با کیفیت ۱۲۸ برحسب کیفیت انتخاب شده باید  در این بخش آپلود گردد!'],
    //             'song_file_320' => ['یک فایل موسیقی با کیفیت ۳۲۰ برحسب کیفیت انتخاب شده باید  در این بخش آپلود گردد!'],
    //          ]);
    //          throw $error;
    //     }
    // }

}