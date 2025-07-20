<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- ¡Añade esto!

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('platforms')->insert([
            ['name' => 'Steam', 'slug' => 'steam'],
            ['name' => 'Epic Games Store', 'slug' => 'epic-games-store'],
            ['name' => 'PC', 'slug' => 'pc'],
            ['name' => 'PlayStation 5', 'slug' => 'playstation-5'],
            ['name' => 'Xbox Series X/S', 'slug' => 'xbox-series-x-s'],
        ]);
    }
}