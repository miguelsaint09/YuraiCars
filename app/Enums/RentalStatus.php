<?php

namespace App\Enums;

enum RentalStatus: string
{
    case SELECTED = 'selected';
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
