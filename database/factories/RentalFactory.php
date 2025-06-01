<?php

namespace Database\Factories;

use App\Enums\RentalStatus;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
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
            'user_id' => User::has('profile')->inRandomOrder()->first()->id,
            'vehicle_id' => Vehicle::factory(),
            'start_time' => fake()->dateTimeBetween('-1 month', 'now'),
            'end_time' => fake()->optional()->dateTimeBetween('now', '+1 month'),
            'pickup_location' => fake()->city(),
            'dropoff_location' => fake()->city(),
            'status' => fake()->randomElement(RentalStatus::values()),
        ];
    }
}
