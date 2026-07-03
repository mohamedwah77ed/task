<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'sku' => strtoupper(fake()->unique()->bothify('SKU-#####')),

            'name' => fake()->words(3, true),

            'description' => fake()->optional()->paragraph(),

            'price' => fake()->randomFloat(2, 10, 5000),

            'stock_quantity' => fake()->numberBetween(0, 100),

            'low_stock_threshold' => fake()->numberBetween(5, 10),

            'status' => fake()->randomElement([
                'active',
                'inactive',
                'discontinued',
            ]),
        ];
    }
}
