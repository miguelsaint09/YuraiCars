<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';      // Payment initiated but not yet completed
    case SUCCESS = 'success';      // Payment completed successfully
    case FAILED = 'failed';        // Payment attempt failed
    case CANCELED = 'canceled';    // Payment was canceled
    case REFUNDED = 'refunded';    // Payment was fully refunded

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
