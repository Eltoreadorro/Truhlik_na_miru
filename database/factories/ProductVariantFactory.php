<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use Faker\Generator as Faker;
use App\Models\ProductVariant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
        'volume'     => $this->faker->randomFloat(2, 0.1, 10), // Генерирует случайное число с 2 знаками после запятой
        'height'     => $this->faker->randomFloat(2, 1, 100),
        'width'      => $this->faker->randomFloat(2, 1, 100),
        'color'      => $this->faker->colorName,
        'price'      => $this->faker->randomFloat(2, 50, 500),
        'stock'      => $this->faker->numberBetween(0, 100),
        'sku'        => $this->faker->unique()->bothify('SKU-####'),
        'image'      => null,
        ];
    }
}
