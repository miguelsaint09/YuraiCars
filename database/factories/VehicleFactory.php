<?php

namespace Database\Factories;

use App\Enums\VehicleCategory;
use App\Enums\VehicleFuelType;
use App\Enums\VehicleMake;
use App\Enums\VehicleStatus;
use App\Enums\VehicleTransmission;
use App\Enums\VehicleFeatures;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
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
            'license_plate' => strtoupper(fake()->bothify('??-####')), // AB-1234
            'name' => fake()->company() . ' ' . fake()->word(),
            'make' => fake()->randomElement(VehicleMake::values()),
            'model' => fake()->word(),
            'year' => fake()->numberBetween(2010, 2025),
            'color' => fake()->safeColorName(),
            'category' => fake()->randomElement(VehicleCategory::values()),
            'image_url' => fake()->optional()->boolean(80) ? [fake()->imageUrl(600, 400, 'cars')] : null,
            'seats' => fake()->randomElement([2, 4, 5, 7, 8]),
            'luggage_capacity' => fake()->numberBetween(100, 500),
            'transmission' => fake()->randomElement(VehicleTransmission::values()),
            'fuel_type' => fake()->randomElement(VehicleFuelType::values()),
            'price_per_day' => fake()->randomFloat(2, 30, 300), // $30 - $300 per day
            'mileage' => fake()->numberBetween(5000, 200000),
            'fuel_efficiency' => fake()->randomElement(['10 km/L', '15 km/L', '20 km/L', '25 km/L']),
            'remarks' => fake()->optional()->sentence(),
            'status' => fake()->randomElement(VehicleStatus::values()),
            'features' => [
                VehicleFeatures::GPS->value,
                VehicleFeatures::BLUETOOTH->value,
                fake()->randomElement([
                    VehicleFeatures::BACKUP_CAMERA->value,
                    VehicleFeatures::CRUISE_CONTROL->value,
                    VehicleFeatures::CLIMATE_CONTROL->value
                ]),
                fake()->randomElement([
                    VehicleFeatures::LEATHER_SEATS->value,
                    VehicleFeatures::SUNROOF->value,
                    VehicleFeatures::PARKING_SENSORS->value
                ]),
                fake()->randomElement([
                    VehicleFeatures::APPLE_CARPLAY->value,
                    VehicleFeatures::ANDROID_AUTO->value,
                    VehicleFeatures::WIFI->value
                ])
            ],
        ];
    }
}
