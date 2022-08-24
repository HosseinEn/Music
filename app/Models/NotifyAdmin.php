<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifyAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "crud_on_songs", 
        "crud_on_albums", 
        "crud_on_artists", 
        "crud_on_users",
        "crud_on_tags"
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
