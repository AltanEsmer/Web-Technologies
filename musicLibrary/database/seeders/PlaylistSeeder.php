<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaylistSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        $playlists = [
            [
                'name' => 'Rock Classics',
                'description' => 'Classic rock songs from the 70s and 80s',
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chill Vibes',
                'description' => 'Relaxing and chill tracks for any time',
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Workout Hits',
                'description' => 'High-energy music for a great workout',
                'is_public' => true,
                'play_count' => 0,
                'settings' => json_encode(['genre_distribution' => []]),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($playlists as $index => $playlist) {
            // Assign each playlist to a different user using modulo to cycle through users
            $user = $users[$index % count($users)];
            $playlist['user_id'] = $user->id;
            
            DB::table('playlists')->insert($playlist);
        }
    }
}