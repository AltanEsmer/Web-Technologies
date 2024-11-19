<?php

namespace App\Http\Controllers;

use App\Services\SpotifyService;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    protected $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function searchSpotify(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return view('spotify.search', [
                'spotifySongs' => [],
                'message' => 'Please enter a search term.'
            ]);
        }

        $songs = $this->spotifyService->searchTracks($query);

        return view('spotify.search', [
            'spotifySongs' => $songs ?? [],
            'message' => $songs === null ? 'Failed to fetch songs from Spotify.' : null,
            'query' => $query
        ]);
    }
}