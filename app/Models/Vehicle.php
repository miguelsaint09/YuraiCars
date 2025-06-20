<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Rental;
use App\Models\Review;

/**
 * @property string $license_plate
 * @property string $name
 * @property string $make
 * @property string $model
 * @property int $year
 * @property string $color
 * @property string $category
 * @property array<string>|null $image_url
 * @property int $seats
 * @property int $luggage_capacity
 * @property string $transmission
 * @property string $fuel_type
 * @property float $price_per_day
 * @property int $mileage
 * @property string|null $fuel_efficiency
 * @property string|null $remarks
 * @property string $status
 * @property array<string> $features
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Rental> $rentals
 */
class Vehicle extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleFactory> */
    use HasFactory, HasUuids;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'license_plate',
        'name',
        'make',
        'model',
        'year',
        'color',
        'category',
        'image_url',
        'seats',
        'luggage_capacity',
        'transmission',
        'fuel_type',
        'price_per_day',
        'mileage',
        'fuel_efficiency',
        'remarks',
        'status',
        'features'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'features' => 'array',
        'image_url' => 'array',
        'year' => 'integer',
        'seats' => 'integer',
        'luggage_capacity' => 'integer',
        'price_per_day' => 'decimal:2',
        'mileage' => 'integer'
    ];

    /**
     * Get the rentals for the vehicle.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Rental, \App\Models\Vehicle>
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the reviews for the vehicle.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Review, \App\Models\Vehicle>
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the formatted mileage.
     */
    public function getMileageFormattedAttribute(): string
    {
        $mileage = $this->attributes['mileage'] ?? 0;
        return number_format((float) $mileage);
    }

    /**
     * Get the formatted price per day.
     */
    public function getPriceFormattedAttribute(): string
    {
        $price = $this->attributes['price_per_day'] ?? 0;
        return '$' . number_format((float) $price, 2);
    }

    /**
     * Get the formatted color.
     */
    public function getColorFormattedAttribute(): string
    {
        $color = $this->attributes['color'] ?? '';
        return ucfirst($color);
    }

    /**
     * Set the color attribute.
     */
    public function setColorAttribute(string $value): void
    {
        $this->attributes['color'] = strtolower($value);
    }

    /**
     * Get the year as integer safely.
     */
    public function getYearAttribute($value): int
    {
        return (int) ($value ?? date('Y'));
    }

    /**
     * Get the seats as integer safely.
     */
    public function getSeatsAttribute($value): int
    {
        return (int) ($value ?? 5);
    }
}
