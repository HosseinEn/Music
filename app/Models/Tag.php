<?php

namespace App\Models;

use App\Events\SendLogToAdminEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;

class Tag extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ["name", "slug", "user_id"];

    public function songs() {
        return $this->morphedByMany(Song::class, 'taggable');
    }

    public function albums() {
        return $this->morphedByMany(Album::class, 'taggable');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public static function boot() {
        parent::boot();
        $user = null;
        if (Auth::check())
            $user = User::where('id', Auth::user()->id)->get()->first();
            
        Tag::creating(function()use ($user) {
            event(new SendLogToAdminEmail($user, "tag.create"));          
        });

        Tag::updating(function()use ($user) {
            event(new SendLogToAdminEmail($user, "tag.update"));          
        });

        Tag::deleting(function()use ($user) {
            event(new SendLogToAdminEmail($user, "tag.delete"));          
        });
    }

}
