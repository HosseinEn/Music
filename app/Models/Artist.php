<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Artist extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ["name", "slug"];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function albums() {
        return $this->hasMany(Album::class);
    }

    public function songs() {
        return $this->hasMany(Song::class);
    }

    public function image() {
        return $this->morphOne(Image::class, "imageable");
    }

    public function scopeLatest(Builder $query) {
        return $query->orderBy('created_at', 'desc');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
