<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'cover_image'
    ];

    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}