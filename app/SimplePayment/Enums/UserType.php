<?php

namespace SimplePayment\Enums;

enum UserType: string
{
    case CUSTOMER = 'customer';
    case SELLER = 'seller';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
