<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create multiple test users
        $users = [
            [
                'name' => 'Test User 1',
                'email' => 'test1@example.com',
                'password' => Hash::make('password'),
                'preferences' => json_encode(['preferred_genres' => []]),
                'two_factor' => json_encode([
                    'enabled' => false,
                    'secret' => null,
                    'recovery_codes' => null
                ])
            ],
            [
                'name' => 'Test User 2',
                'email' => 'test2@example.com',
                'password' => Hash::make('password'),
                'preferences' => json_encode(['preferred_genres' => []]),
                'two_factor' => json_encode([
                    'enabled' => false,
                    'secret' => null,
                    'recovery_codes' => null
                ])
            ],
            [
                'name' => 'Test User 3',
                'email' => 'test3@example.com',
                'password' => Hash::make('password'),
                'preferences' => json_encode(['preferred_genres' => []]),
                'two_factor' => json_encode([
                    'enabled' => false,
                    'secret' => null,
                    'recovery_codes' => null
                ])
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->call([
            PlaylistSeeder::class,
            PlaylistSongsSeeder::class
        ]);
    }
}