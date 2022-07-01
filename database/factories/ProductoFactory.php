<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $barcode = $this->faker->ean8();
        $name = $this->faker->sentence(2);
        $stock = $this->faker->randomDigitNotNull();
        $cost = $this->faker->randomDigitNotNull();

        return [
            'barcode' => $barcode,
            'name' => $name,
            'description' => $this->faker->sentence(3),
            'key_product' => $this->faker->randomElement(['50161813', '50161814', '50161815 ', '50161800']),
            'stock' => $stock,
            'cost' => $cost,
            'price' => $cost + 2,
            'status' => Producto::Activo,
        ];
    }
}
