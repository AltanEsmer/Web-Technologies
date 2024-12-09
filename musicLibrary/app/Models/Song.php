<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'album',
        'cover_art',
        'spotify_id',
        'duration_ms'
    ];

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class)
                    ->withPivot('position')
                    ->withTimestamps();
    }
}