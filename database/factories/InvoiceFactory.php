<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['B', 'P', 'V']);
        return [
            'customer_id' => Customer::factory(),
            'amount' => $this->faker->numberBetween(200, 1000),
            'status' => $status,
            'billed_date' => $this->faker->dateTimeThisMonth(),
            'paid_dated' => $status == 'P' ? $this->faker->dateTimeThisMonth() : NULL
        ];
    }
}
