<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $playlists = Playlist::where('user_id', auth()->id())->with('songs')->get();
        return view('library', compact('playlists'));
    }
}