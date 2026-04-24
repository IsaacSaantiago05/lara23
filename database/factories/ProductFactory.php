<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Product::class;

    public function definition(): array
    {
    
        return [
            'name' => fake()->name(),
            'description' => fake()->sentence(7),
            'descriptionLong' => fake()->text,
            'price' => fake()->randomFloat(2, 7, 777),
            
        ];
    }
}
