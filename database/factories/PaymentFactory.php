<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Rental;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'rental_id' => Rental::factory(),
            'amount' => fake()->randomFloat(2, 50, 3000),
            'payment_method' => fake()->randomElement(PaymentMethod::values()),
            'status' => fake()->randomElement(PaymentStatus::values()),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
