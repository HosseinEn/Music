<?php

namespace App\Models;

use App\Traits\ModelsCommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    use ModelsCommonMethods;

    protected $fillable = ["name", "slug", "user_id", "released_date", "artist_id", "duration"];

    public function artist() {
        return $this->belongsTo(Artist::class);
    }

    public function songs() {
        return $this->hasMany(Song::class);
    }
}
