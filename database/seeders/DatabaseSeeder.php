<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marcas;
use App\Models\Productos;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crea 25 registros de marcas
        Marcas::factory(25)->create();

        // Crea 15 registros de productos
        Productos::factory(15)->create();

        // Asocia cada producto con una marca aleatoria
        for ($i = 1; $i <= 15; $i++) {
            $producto = Productos::find($i);
            $producto->marcas()->attach(random_int(1, 25)); // Debe usar 'marca_id', no 'marcas_id'
        }
    }
}
