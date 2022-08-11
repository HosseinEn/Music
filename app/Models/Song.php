<?php

namespace App\Models;

use App\Traits\ModelsCommonMethods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    use ModelsCommonMethods;

    protected $fillable = ["name", "slug", "quality", "duration", "released_date", "artist_id", "user_id"];

    public function artist() {
        return $this->belongsTo(Artist::class);
    }

    public function album() {
        return $this->belongsTo(Album::class);
    }

    public function scopeSoloSongs(Builder $query) {
        return $query->doesntHave('album');
    }

    public function tags() {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
