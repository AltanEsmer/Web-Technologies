<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\Song;
use App\Services\SpotifyService;
use Illuminate\Database\Seeder;

class PlaylistSongsSeeder extends Seeder
{
    protected $spotifyService;

    public function __construct()
    {
        $this->spotifyService = new SpotifyService();
    }

    public function run()
    {
        $playlists = Playlist::all();
        $searchTerms = [
            'rock', 'pop', 'jazz', 'classical', 'hip hop', 'indie', 'electronic', 
            'reggae', 'blues', '80s', '90s', 'lo-fi', 'chill', 'party', 'r&b', 
            'workout', 'acoustic', 'country', 'happy', 'sad'
        ];

        foreach ($playlists as $playlist) {
            $position = 0;
            $searchTerm = $searchTerms[array_rand($searchTerms)];
            
            $tracks = $this->spotifyService->searchTracks($searchTerm);
            
            if ($tracks) {
                foreach ($tracks as $track) {
                    $song = Song::firstOrCreate(
                        ['spotify_id' => $track['id']],
                        [
                            'title' => $track['name'],
                            'artist' => $track['artists'][0]['name'],
                            'album' => $track['album']['name'],
                            'cover_art' => $track['album']['images'][0]['url'] ?? null,
                            'duration_ms' => $track['duration_ms'] ?? null,
                            'popularity' => $track['popularity'] ?? 0,
                            'explicit' => $track['explicit'] ?? false,
                            'genres' => json_encode([])
                        ]
                    );

                    if (!$playlist->songs->contains($song->id)) {
                        $playlist->songs()->attach($song->id, [
                            'position' => $position++,
                            'metadata' => json_encode(['added_at' => now()])
                        ]);
                    }
                }
            }
        }
    }
}