<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpotifyService
{
    protected $clientId = '2c5bcb785c644b058a82398c6755b4f1';
    protected $clientSecret = 'b9fb6fdecdc74b37a1ff51f3ec11d085';
    protected $tokenUrl = 'https://accounts.spotify.com/api/token';
    protected $searchUrl = 'https://api.spotify.com/v1/search';

    protected function getAccessToken()
    {
        if (Cache::has('spotify_token')) {
            return Cache::get('spotify_token');
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