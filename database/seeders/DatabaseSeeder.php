<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@pardomuan.com'],
            [
                'name' => 'Admin Desa',
                'password' => bcrypt('password123'),
            ]
        );

        $this->call([
            WebsiteSeeder::class,
        ]);
    }
}
