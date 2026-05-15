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
        \App\Models\User::factory()->create([
            'name' => 'Admin Desa',
            'email' => 'admin@pardomuan.com',
            'password' => bcrypt('password123'),
        ]);

        $this->call([
            WebsiteSeeder::class,
        ]);
    }
}
