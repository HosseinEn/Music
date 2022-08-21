<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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

    public static function boot() {
        parent::boot();
    }
}
