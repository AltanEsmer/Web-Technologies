<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpotifyController extends Controller
{
    protected $clientId;
    protected $clientSecret;
    protected $tokenUrl;
    protected $apiUrl;

    public function __construct()
    {
        $this->clientId = config('spotify.client_id');
        $this->clientSecret = config('spotify.client_secret');
        $this->tokenUrl = config('spotify.token_url');
        $this->apiUrl = config('spotify.api_url');
    }

    protected function getAccessToken()
    {
        if (Cache::has('spotify_token')) {
            return Cache::get('spotify_token');
        }

        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post($this->tokenUrl, [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            $token = $response->json()['access_token'];
            $expiresIn = $response->json()['expires_in'] - 60; // Buffer of 60 seconds
            Cache::put('spotify_token', $token, $expiresIn);
            return $token;
        }

        throw new \Exception('Failed to get Spotify access token');
    }

    public function searchSpotify(Request $request)
    {
        try {
            $query = $request->get('query');
            if (empty($query)) {
                return response()->json(['error' => 'Search query is required'], 400);
            }

            $token = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($this->apiUrl . '/search', [
                'q' => $query,
                'type' => 'track',
                'limit' => 10
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Failed to fetch results from Spotify'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}