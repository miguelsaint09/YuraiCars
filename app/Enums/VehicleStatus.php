<?php

namespace App\Enums;

enum VehicleStatus: string
{
    case AVAILABLE = 'available';
    case BOOKED = 'booked';
    case RENTED = 'rented';
    case MAINTENANCE = 'maintenance';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
