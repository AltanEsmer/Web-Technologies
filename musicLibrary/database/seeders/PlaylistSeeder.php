<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('playlists')->insert([
            [
                'name' => 'Rock Classics',
                'description' => 'Classic rock songs from the 70s and 80s',
                'user_id' => 1, // Make sure this user exists
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Chill Vibes',
                'description' => 'Relaxing and chill tracks for any time',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Workout Hits',
                'description' => 'High-energy music for a great workout',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
    }
