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

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE => 'Disponible',
            self::BOOKED => 'Reservado',
            self::RENTED => 'Alquilado',
            self::MAINTENANCE => 'En Mantenimiento',
        };
    }
}
