<?php

namespace App\Traits;

use App\Models\Image;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;

trait ModelsCommonMethods{
    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
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

    public function user() {
        return $this->belongsTo(User::class);
    }
}
