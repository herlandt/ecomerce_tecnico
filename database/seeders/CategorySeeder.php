<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- ¡Añade esto!

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Juegos Digitales', 'slug' => 'juegos-digitales'],
            ['name' => 'Cosméticos', 'slug' => 'cosmeticos'],
            ['name' => 'Tarjetas de Regalo', 'slug' => 'tarjetas-de-regalo'],
            ['name' => 'Accesorios', 'slug' => 'accesorios'],
        ]);
    }
}