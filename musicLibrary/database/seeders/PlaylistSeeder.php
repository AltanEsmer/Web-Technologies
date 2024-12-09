<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaylistSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('playlists')->insert([
            [
                'name' => 'Rock Classics',
                'description' => 'Classic rock songs from the 70s and 80s',
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\rock_image.jpg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chill Vibes',
                'description' => 'Relaxing and chill tracks for any time',
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\chill_vibes.jpg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Workout Hits',
                'description' => 'High-energy music for a great workout',
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\workout_mix.jpg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Country Roads',
                'description' => 'A collection of the best country music',
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\country_roads.png',
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
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\jazz.jpeg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pop Hits',
                'description' => 'The most popular hits from today and yesterday',
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\pop_hits.jpg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Throwback 90s',
                'description' => 'Take a trip back to the 90s with these hits',
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\90s.jpeg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Classical Favorites',
                'description' => 'Beautiful classical pieces for any occasion',
                'user_id' => 1,
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\classic_songs.jpg',
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Party Time',
                'description' => 'Get the party started with these upbeat tracks',
                'cover_image' => 'smusicLibrary\storage\app\public\playlist-covers\party_songs.jpg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Indie Mix',
                'description' => 'A mix of the best indie tracks from emerging artists',
                'cover_image' => 'musicLibrary\storage\app\public\playlist-covers\indie_songs.jpeg',
                'user_id' => 1,
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}