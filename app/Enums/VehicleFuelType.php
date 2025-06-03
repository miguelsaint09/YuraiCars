<?php

namespace App\Enums;

enum VehicleFuelType: string
{
    case PETROL = 'gasolina';
    case DIESEL = 'diesel';
    case ELECTRIC = 'eléctrico';
    case HYBRID = 'híbrido';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string 
    {
        return match($this) {
            self::PETROL => 'Gasolina',
            self::DIESEL => 'Diesel',
            self::ELECTRIC => 'Eléctrico', 
            self::HYBRID => 'Híbrido',
        };
    }
}
