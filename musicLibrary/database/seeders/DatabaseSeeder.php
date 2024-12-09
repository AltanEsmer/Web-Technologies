<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Music Library',
            'email' => 'user@admin.com',
            'password' => Hash::make('password'),
            'preferences' => json_encode(['preferred_genres' => []]),
            'two_factor' => json_encode([
                'enabled' => false,
                'secret' => null,
                'recovery_codes' => null
            ])
        ]);

        $this->call([
            PlaylistSeeder::class,
            PlaylistSongsSeeder::class
        ]);
    }
}