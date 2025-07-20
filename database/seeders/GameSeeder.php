<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- ¡Añade esto!

class GameSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('games')->insert([
            ['name' => 'Fortnite', 'slug' => 'fortnite'],
            ['name' => 'Valorant', 'slug' => 'valorant'],
            ['name' => 'Dota 2', 'slug' => 'dota-2'],
            ['name' => 'League of Legends', 'slug' => 'league-of-legends'],
        ]);
    }
}