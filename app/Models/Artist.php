<?php

namespace App\Models;

use App\Events\SendLogToAdminEmail;
use App\Traits\ModelsCommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Artist extends Model
{
    use ModelsCommonMethods;
    use HasFactory;

    protected $fillable = ["name", "slug", "user_id"];

    public function albums() {
        return $this->hasMany(Album::class);
    }

    public function songs() {
        return $this->hasMany(Song::class);
    }

    public function likes() {
        return $this->morphToMany(User::class, "likeable");
    }

    public function scopeSoloSongs(Builder $query) {
        return $this->songs()->doesntHave('album');
    }

    public function userLiked() {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

    public static function boot() {
        parent::boot();
        $user = null;
        if(Auth::check()) 
            $user = User::where('id', Auth::user()->id)->get()->first();
        
        Artist::creating(function() use ($user) {
            event(new SendLogToAdminEmail($user, "artist.create"));          
        });

        Artist::updating(function() use ($user) {
            event(new SendLogToAdminEmail($user, "artist.update"));          
        });

        Artist::deleting(function($artist) use ($user) {
            $artist->image->delete();

            $albums = $artist->albums;
            foreach($albums as $album) {
                $album->delete();
            }

            $songs = $artist->songs;
            foreach($songs as $song) {
                $song->delete();
            }
            $artist->likes()->detach();
            event(new SendLogToAdminEmail($user, "artist.delete"));          
        });
    }
}
