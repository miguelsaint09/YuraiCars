<?php

namespace App\Enums;

enum VehicleMake: string
{
    case TOYOTA = 'Toyota';
    case HONDA = 'Honda';
    case FORD = 'Ford';
    case BMW = 'BMW';
    case MERCEDES = 'Mercedes';
    case AUDI = 'Audi';
    case NISSAN = 'Nissan';
    case CHEVROLET = 'Chevrolet';
    case TESLA = 'Tesla';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
