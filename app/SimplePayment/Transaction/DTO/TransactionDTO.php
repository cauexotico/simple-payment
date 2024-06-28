<?php

namespace SimplePayment\Transaction\DTO;

class TransactionDTO
{
    public string $payer_id;
    public string $payee_id;
    public string $amount;

    public function __construct(string $payer_id, string $payee_id, string $amount)
    {
        $this->payer_id = $payer_id;
        $this->payee_id = $payee_id;
        $this->amount = $amount;
    }
}
