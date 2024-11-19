<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpotifyService
{
    protected $clientId;
    protected $clientSecret;
    protected $tokenUrl = 'https://accounts.spotify.com/api/token';
    protected $searchUrl = 'https://api.spotify.com/v1/search';

    public function __construct()
    {
        $this->clientId = config('services.spotify.client_id');
        $this->clientSecret = config('services.spotify.client_secret');
        
        if (!$this->clientId || !$this->clientSecret) {
            throw new \Exception('Spotify credentials not configured');
        }
    }

    protected function getAccessToken()
    {
        if (Cache::has('spotify_token')) {
            return Cache::get('spotify_token');
        }

        if (!$this->tokenUrl) {
            throw new \Exception('Token URL not configured');
        }

        try {
            $response = Http::asForm()->post($this->tokenUrl, [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Cache::put('spotify_token', $data['access_token'], now()->addSeconds($data['expires_in']));
                return $data['access_token'];
            }
        } catch (\Exception $e) {
            \Log::error('Spotify token error: ' . $e->getMessage());
        }

        return null;
    }

    public function searchTracks($query)
    {
        if (empty($query)) {
            return null;
        }

        $token = $this->getAccessToken();
        if (!$token) {
            \Log::error('Failed to get Spotify access token');
            return null;
        }

        try {
            $response = Http::withToken($token)->get($this->searchUrl, [
                'q' => $query,
                'type' => 'track',
                'limit' => 10
            ]);

            if ($response->successful()) {
                return $response->json()['tracks']['items'];
            }
        } catch (\Exception $e) {
            \Log::error('Spotify search error: ' . $e->getMessage());
        }

        return null;
    }
}