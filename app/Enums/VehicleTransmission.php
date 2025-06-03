<?php

namespace App\Enums;

enum VehicleTransmission: string
{
    case AUTOMATIC = 'automático';
    case MANUAL = 'manual';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::AUTOMATIC => 'Automático',
            self::MANUAL => 'Manual',
        };
    }
}
