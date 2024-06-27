<?php

namespace SimplePayment\Enums;

enum TransactionStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case NOTIFIED = 'notified';
    case FINISHED = 'finished';

    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    case ERROR = 'error';


    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
