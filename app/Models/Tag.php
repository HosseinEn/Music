<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function songs() {
        return $this->morphedByMany(Song::class, 'taggable');
    }

    public function albums() {
        return $this->morphedByMany(Album::class, 'taggable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
