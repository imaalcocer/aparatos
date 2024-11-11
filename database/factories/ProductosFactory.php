<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Productos>
 */
class ProductosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo_producto' => $this->faker->unique()->numerify('PROD-####'), // Genera un código de producto único
            'title' => $this->faker->sentence(2), // Genera un título con 2 palabras
            'description' => $this->faker->text(100), // Genera una descripción de 100 caracteres
            'release_date' => $this->faker->date(), // Genera una fecha aleatoria
            'image' => '/img/example.png' // Ruta de imagen estática
        ];
    }
}
