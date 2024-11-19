<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_id',
        'title',
        'artist',
        'album',
        'cover_art'
    ];

    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song');
    }
}