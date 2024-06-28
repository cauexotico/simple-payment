<?php

namespace SimplePayment\Transaction;

use Exception;

class TransactionException extends Exception
{
    public static function payerNotFound(): self
    {
        return new self("Unable to find payer");
    }

    public static function payeeNotFound(): self
    {
        return new self("Unable to find payee");
    }

    public static function sellersCantSendMoney(): self
    {
        return new self("Sellers cannot send money.");
    }

    public static function insufficientFunds(): self
    {
        return new self("Payer did not have sufficient funds.");
    }
}
