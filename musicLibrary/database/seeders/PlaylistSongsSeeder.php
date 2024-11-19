<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Models\Song;
use App\Services\SpotifyService;

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
        $searchTerms = ['rock', 'pop', 'jazz', 'classical', 'hip hop'];

        foreach ($playlists as $playlist) {
            $searchTerm = $searchTerms[array_rand($searchTerms)];
            
            $tracks = $this->spotifyService->searchTracks($searchTerm);
            
            if ($tracks) {
                foreach ($tracks as $track) {
                    $song = Song::firstOrCreate(
                        [
                            'spotify_id' => $track['id'],
                            'title' => $track['name'],
                            'artist' => $track['artists'][0]['name'],
                            'album' => $track['album']['name']
                        ],
                        [
                            'cover_art' => $track['album']['images'][0]['url'] ?? null
                        ]
                    );

                    if (!$playlist->songs->contains($song->id)) {
                        $playlist->songs()->attach($song->id);
                    }
                }

                $this->command->info("Added songs to playlist: {$playlist->name}");
            } else {
                $this->command->error("Failed to fetch songs for playlist: {$playlist->name}");
            }
        }
    }
}