<?php

namespace App\Enums;

enum VehicleCategory: string
{
    case SEDAN = 'Sedan';
    case SUV = 'SUV';
    case HATCHBACK = 'Hatchback';
    case CONVERTIBLE = 'Convertible';
    case TRUCK = 'Truck';
    case VAN = 'Van';
    case COUPE = 'Coupe';
    case WAGON = 'Wagon';
    case ELECTRIC = 'Electric';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
