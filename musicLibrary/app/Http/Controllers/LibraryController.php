<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        // Get user's playlists
        $playlists = Playlist::where('user_id', auth()->id())
            ->with(['songs', 'user'])
            ->get();

        // Get public playlists (excluding user's own playlists)
        $publicPlaylists = Playlist::where('is_public', true)
            ->where('user_id', '!=', auth()->id())
            ->with(['songs', 'user'])
            ->latest()
            ->take(8)
            ->get();

        return view('library', compact('playlists', 'publicPlaylists'));
    }
}