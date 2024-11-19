<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Support\Facades\Http;

class PlaylistSongsSeeder extends Seeder
{
    protected $spotifyToken;

    public function __construct()
    {
        $this->spotifyToken = config('services.spotify.token');
    }

    public function run()
    {
        $playlists = Playlist::all();
        $searchTerms = ['rock', 'pop', 'jazz', 'classical', 'hip hop'];

        foreach ($playlists as $playlist) {
            // Randomly select a search term
            $searchTerm = $searchTerms[array_rand($searchTerms)];
            
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->spotifyToken
                ])->get('https://api.spotify.com/v1/search', [
                    'q' => $searchTerm,
                    'type' => 'track',
                    'limit' => 5 // Get 5 songs per playlist
                ]);

                if ($response->successful()) {
                    $tracks = $response->json()['tracks']['items'];
                    
                    foreach ($tracks as $track) {
                        $song = Song::firstOrCreate(
                            [
                                'title' => $track['name'],
                                'artist' => $track['artists'][0]['name'],
                                'album' => $track['album']['name']
                            ],
                            [
                                'cover_art' => $track['album']['images'][0]['url'] ?? null
                            ]
                        );

                        // Attach song to playlist if not already attached
                        if (!$playlist->songs->contains($song->id)) {
                            $playlist->songs()->attach($song->id);
                        }
                    }

                    $this->command->info("Added songs to playlist: {$playlist->name}");
                }
            } catch (\Exception $e) {
                $this->command->error("Error adding songs to playlist {$playlist->name}: {$e->getMessage()}");
            }
        }
    }
}