<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PublicationSeeder::class,
            FavoriteSeeder::class,
            ImageSeeder::class
        ]);
    }
}
