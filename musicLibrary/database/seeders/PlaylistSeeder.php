<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;

class PlaylistSeeder extends Seeder
{
    public function run()
    {
        $playlists = [
            [
                'name' => 'Rock Classics',
                'description' => 'Classic rock hits from all time',
                'cover_image' => 'images/playlist_pics/rock.jpg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chill Vibes',
                'description' => 'Relaxing tunes to unwind',
                'cover_image' => 'images/playlist_pics/chill.jpg',
                'user_id' => 2,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Workout Hits',
                'description' => 'High-energy songs for your workout',
                'cover_image' => 'images/playlist_pics/workout.jpg',
                'user_id' => 3,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Country Roads',
                'description' => 'Best country music collection',
                'cover_image' => 'images/playlist_pics/country.png',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Jazz Essentials',
                'description' => 'Timeless jazz tracks for a smooth experience',
                'cover_image' => 'images/playlist_pics/jazz.jpeg',
                'user_id' => 2,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pop Hits',
                'description' => 'The most popular hits from today and yesterday',
                'cover_image' => 'images/playlist_pics/pop.jpg',
                'user_id' => 3,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Throwback 90s',
                'description' => 'Take a trip back to the 90s with these hits',
                'cover_image' => 'images/playlist_pics/90s.jpeg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Classical Favorites',
                'description' => 'The best classical music collection',
                'cover_image' => 'images/playlist_pics/classical.jpg',
                'user_id' => 2,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($playlists as $playlist) {
            Playlist::create($playlist);
        }
    }
}