<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CREDIT_CARD = 'credit_card';
    case DEBIT_CARD = 'debit_card';
    case BANK_TRANSFER = 'bank_transfer';
    case CASH = 'cash';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
