<?php

namespace SimplePayment\Transaction\Repositories;

use SimplePayment\Transaction\DTO\TransactionDTO;
use SimplePayment\Enums\TransactionStatus;
use SimplePayment\Transaction\Transaction;

class TransactionRepository
{
    public function createTransaction(TransactionDTO $transactionDTO, $payer, $payee): Transaction
    {
        return Transaction::create([
            'payer_id' => $payer->getKey(),
            'payer_type' => get_class($payer),
            'payee_id' => $payee->getKey(),
            'payee_type' => get_class($payee),
            'amount' => $transactionDTO->amount,
            'status' => TransactionStatus::PENDING,
        ]);
    }

    public function transferMoney(Transaction $transaction): Transaction
    {
        $transaction->payer->wallet->removeBalance($transaction->amount);
        $transaction->payee->wallet->addBalance($transaction->amount);

        return $transaction;
    }
}
