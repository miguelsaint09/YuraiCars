<?php

namespace App\Enums;

enum VehicleFuelType: string
{
    case PETROL = 'petrol';
    case DIESEL = 'diesel';
    case ELECTRIC = 'electric';
    case HYBRID = 'hybrid';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
