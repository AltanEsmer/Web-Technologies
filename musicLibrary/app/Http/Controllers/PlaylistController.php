<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;  // Ensure Song model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlaylistController extends Controller
{
    public function show($id)
    {
        $playlist = Playlist::find($id);
        if (!$playlist) {
            abort(404, 'Playlist not found');
        }
        return view('show', compact('playlist'));
    }

    public function create()
    {
        return view('playlist.create');
    }

    public function searchSpotify(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return view('spotify.search', ['spotifySongs' => [], 'message' => 'Please enter a search term.']);
        }

        // Step 1: Hard-code client ID and client secret for testing purposes
        

        // Request Access Token
        $response = Http::post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => '2c5bcb785c644b058a82398c6755b4f1',
            'client_secret' => 'b9fb6fdecdc74b37a1ff51f3ec11d085',
        ]);

        if (!$response->successful()) {
            Log::error('Failed to retrieve access token', [
                'error' => $response->json()
            ]);
            return view('spotify.search', [
                'spotifySongs' => [],
                'message' => 'Failed to connect to Spotify API. Please try again later.'
            ]);
        }

        $accessToken = $response->json()['access_token'] ?? null;

        if (!$accessToken) {
            Log::error('Access token not found in Spotify API response', [
                'response' => $response->json()
            ]);
            return view('spotify.search', [
                'spotifySongs' => [],
                'message' => 'Could not retrieve access token. Please check your Spotify API credentials.'
            ]);
        }

        // Step 2: Perform the actual search with the access token
        $results = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.spotify.com/v1/search', [
            'q' => $query,
            'type' => 'track',
            'limit' => 10,
        ]);

        $spotifySongs = $results->json()['tracks']['items'] ?? [];

        return view('spotify.search', compact('spotifySongs'));
    }

    private function getSpotifyAccessToken()
    {
        $response = Http::asForm()->post("https://accounts.spotify.com/api/token", [
            'grant_type' => 'client_credentials',
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
        ]);

        return $response->json()['access_token'] ?? null;
    }

    public function addSong(Request $request, Playlist $playlist)
    {
        $songData = $request->input('song');

        $song = Song::firstOrCreate(
            ['spotify_id' => $songData['spotify_id']],
            [
                'title' => $songData['title'],
                'artist' => $songData['artist'],
                'album' => $songData['album'],
                'cover_art' => $songData['cover_art'],
            ]
        );

        $playlist->songs()->attach($song->id);

        return redirect()->route('playlist.show', $playlist->id)->with('success', 'Song added to playlist!');
    }
}
