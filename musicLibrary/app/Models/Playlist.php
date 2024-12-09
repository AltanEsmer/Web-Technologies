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
        'cover_image',
        'user_id',
        'is_public'
    ];

    // Add this to ensure boolean casting
    protected $casts = [
        'is_public' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class)
                    ->withPivot('position')
                    ->withTimestamps()
                    ->orderBy('position');
    }
}