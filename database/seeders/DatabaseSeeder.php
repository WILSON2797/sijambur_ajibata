<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@pardomuan.com'],
            [
                'name' => 'Admin Desa',
                'password' => Hash::make('password123'),
            ]
        );

        $this->call([
            WebsiteSeeder::class,
        ]);
    }
}
