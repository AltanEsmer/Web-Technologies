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