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
            ],
            [
                'name' => 'Chill Vibes',
                'description' => 'Relaxing and chill tracks for any time',
            ],
            [
                'name' => 'Workout Hits',
                'description' => 'High-energy music for a great workout',
            ],
        ]);
    }
}
