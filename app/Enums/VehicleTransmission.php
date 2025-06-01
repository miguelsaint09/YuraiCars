<?php

namespace App\Enums;

enum VehicleTransmission: string
{
    case AUTOMATIC = 'automatic';
    case MANUAL = 'manual';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
