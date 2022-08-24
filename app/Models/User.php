<?php

namespace App\Models;

use App\Events\SendLogToAdminEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function artists() {
        return $this->hasMany(Artist::class);
    }

    public function tags() {
        return $this->hasMany(Tag::class);
    }

    public function songs() {
        return $this->hasMany(Song::class);
    }

    public function albums() {
        return $this->hasMany(Album::class);
    }


    public function likedSongs() {
        return $this->morphedByMany(Song::class, "likeable")->withTimestamps();
    }

    public function likedAlbums() {
        return $this->morphedByMany(Album::class, "likeable")->withTimestamps();
    }

    public function likedArtists() {
        return $this->morphedByMany(Artist::class, "likeable")->withTimestamps();
    }

    public function notifyAdmin() {
        return $this->hasOne(NotifyAdmin::class);
    }

    public function scopeIsAdmin(Builder $query) {
        return $query->where('is_admin', true);
    }

    public static function boot() {
        parent::boot();
        $user = null;
        if (Auth::check())
            $user = User::where('id', Auth::user()->id)->get()->first();
            
        User::updating(function() use ($user) {
            event(new SendLogToAdminEmail($user, "user.update"));          
        });

        User::deleting(function() use ($user) {
            event(new SendLogToAdminEmail($user, "user.delete"));          
        });
    }
}
