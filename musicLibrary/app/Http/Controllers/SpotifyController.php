<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SpotifyController extends Controller
{
    public function searchSpotify(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return view('spotify.search', ['spotifySongs' => [], 'message' => 'Please enter a search term.']);
        }

        // Hardcoded Client ID and Secret (for testing only; consider using .env in production)
        $clientId = '2c5bcb785c644b058a82398c6755b4f1';
        $clientSecret = 'b9fb6fdecdc74b37a1ff51f3ec11d085';

        // Request token and handle errors
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]);

        if ($response->failed()) {
            Log::error('Failed to retrieve access token from Spotify:', ['response' => $response->body()]);
            return view('spotify.search', [
                'spotifySongs' => [],
                'message' => 'Failed to retrieve access token. Please check your Spotify API credentials.',
            ]);
        }

        $accessToken = $response->json()['access_token'] ?? null;

        if (!$accessToken) {
            Log::error('Access token is null after retrieving token from Spotify.');
            return view('spotify.search', [
                'spotifySongs' => [],
                'message' => 'Failed to retrieve access token. Please check your Spotify API credentials.',
            ]);
        }

        // Perform the actual search with the access token
        $results = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://api.spotify.com/v1/search', [
            'q' => $query,
            'type' => 'track',
            'limit' => 10, // Limit the number of results
        ]);

        if ($results->failed()) {
            Log::error('Spotify API search failed:', ['response' => $results->body()]);
            return view('spotify.search', [
                'spotifySongs' => [],
                'message' => 'Failed to retrieve search results from Spotify. Please try again later.',
            ]);
        }

        $spotifySongs = $results->json()['tracks']['items'] ?? [];

        return view('spotify.search', compact('spotifySongs'));
    }
}
