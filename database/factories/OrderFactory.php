<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

                'date' => $this->faker->date(),
                'order_status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
                'invoice_no' => $this->faker->unique()->numerify('INV-####'),
                'total_products' => $this->faker->numberBetween(1, 20),
                'total_price' => $this->faker->randomFloat(2, 100, 10000),
                'sub_total' => $this->faker->randomFloat(2, 100, 10000),
                'vat' => $this->faker->randomFloat(2, 0, 20),
                'payment_status' => $this->faker->randomElement(['paid', 'unpaid', 'partial']),
                'pay' => $this->faker->randomFloat(2, 0, 5000),
                'due' => $this->faker->randomFloat(2, 0, 5000),
                'customer_id' => $this->faker->randomElement(Customer::all()->pluck('id')->toArray()),
                'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),

        ];
    }
}
