<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
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
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->bothify('PRD-#####'),
            'description' => $this->faker->optional()->paragraph,
            'buying_price' => $this->faker->randomFloat(2, 10, 100),
            'selling_price' => $this->faker->randomFloat(2, 20, 150),
            'stock' => $this->faker->numberBetween(0, 500),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'products', true),
            'buying_date' => $this->faker->optional()->date(),
            'category_id' => $this->faker->numberBetween(1, 10),
            'supplier_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
