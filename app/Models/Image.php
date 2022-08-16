<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ["path"];

    public function artist() {
        return $this->morphTo();
    }

    public function song() {
        return $this->morphTo();
    }

    public function album() {
        return $this->morphTo();
    }

    public function url() {
        return Storage::url($this->path);
    }

    public static function boot() {
        parent::boot();

        Image::deleting(function($image) {
            $imagePath = $image->path;
            Storage::delete($imagePath);
        });
    }
}
