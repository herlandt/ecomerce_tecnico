<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Importante para generar códigos aleatorios

class ActivationCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        DB::table('activation_codes')->delete();

        // --- Códigos para Cyberpunk 2077 (product_id = 1) ---
        for ($i = 0; $i < 5; $i++) { // Crearemos 5 códigos
            DB::table('activation_codes')->insert([
                'product_id' => 1,
                'code' => 'CYBER-'.strtoupper(Str::random(12)),
                'is_sold' => false,
            ]);
        }

        // --- Códigos para la Skin de Valorant (product_id = 2) ---
        for ($i = 0; $i < 10; $i++) { // Crearemos 10 códigos
            DB::table('activation_codes')->insert([
                'product_id' => 2,
                'code' => 'VALOR-'.strtoupper(Str::random(12)),
                'is_sold' => false,
            ]);
        }

        // --- Códigos para la Tarjeta de Regalo (product_id = 3) ---
        for ($i = 0; $i < 8; $i++) { // Crearemos 8 códigos
            DB::table('activation_codes')->insert([
                'product_id' => 3,
                'code' => 'STEAM-'.strtoupper(Str::random(12)),
                'is_sold' => false,
            ]);
        }

        // --- Códigos (o números de serie) para el Mouse (product_id = 4) ---
        for ($i = 0; $i < 3; $i++) { // Crearemos 3 códigos/series
            DB::table('activation_codes')->insert([
                'product_id' => 4,
                'code' => 'LOGI-'.strtoupper(Str::random(12)),
                'is_sold' => false,
            ]);
        }
    }
}