<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongFile extends Model
{
    use HasFactory;
    protected $fillable = ["quality", "duration", "path", "extension"];

    public function song() {
        return $this->belongsTo(Song::class);
    }

    public function scopeQuality128Path(Builder $query) {
        $song = $query->where('quality', 128);
        if($song->exists()) {
            return $song->get()->first()->path;
        }
        else {
            return "";
        }
    }

    public function scopeQuality320Path(Builder $query) {
        $song = $query->where('quality', 320);
        if($song->exists()) {
            return $song->get()->first()->path;
        }
        else {
            return "";
        }
    }

    public function scopeGet128File(Builder $query) {
        return $query->where('quality', 128)->get();
    }

    public function scopeGet320File(Builder $query) {
        return $query->where('quality', 320)->get();
    }

    public function scopeQuality128Exists(Builder $query) {
        return $query->where('quality', 128)->exists();
    }

    public function scopeQuality320Exists(Builder $query) {
        return $query->where('quality', 320)->exists();
    }
}
