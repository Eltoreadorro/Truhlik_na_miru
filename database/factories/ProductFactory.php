<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'name' => fake()->words(3, true),
        'sku' => fake()->unique()->ean13(),
        'description' => fake()->paragraph,
        'price' => fake()->numberBetween(100, 10000),
        'sku' => fake()->unique()->ean13(),
        'category_id' => Category::inRandomOrder()->first()->id, // Берем случайную категорию
    ];
}
}
