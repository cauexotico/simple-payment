<?php

namespace SimplePayment\Transaction\Services;

use SimplePayment\Customer\Customer;
use SimplePayment\Enums\TransactionStatus;
use SimplePayment\Seller\Seller;
use SimplePayment\Transaction\DTO\TransactionDTO;
use SimplePayment\Transaction\Transaction;
use SimplePayment\Transaction\TransactionException;
use SimplePayment\Wallet\Wallet;

class TransactionService
{
    public function createTransaction(TransactionDTO $transactionDTO): Transaction
    {
        $this->validateTransactionRequirements($transactionDTO);

        $walletPayer = Wallet::where('holder_id', $transactionDTO->payer_id)->first();
        $walletPayer->remove($transactionDTO->amount);

        $walletPayee = Wallet::where('holder_id', $transactionDTO->payee_id)->first();

        $transaction = Transaction::create([
            'payer_id' => $transactionDTO->payer_id,
            'payer_type' => get_class($walletPayer->holder),
            'payee_id' => $transactionDTO->payee_id,
            'payee_type' => get_class($walletPayee->holder),
            'amount' => $transactionDTO->amount,
            'status' => TransactionStatus::PENDING,
        ]);

        $transaction->payee->wallet->add($transactionDTO->amount);

        $transaction->setStatus(TransactionStatus::APPROVED);

        $transaction->setStatus(TransactionStatus::FINISHED);

        $transaction->setStatus(TransactionStatus::NOTIFIED);

        return $transaction;
    }

    private static function validateTransactionRequirements(TransactionDTO $transactionDTO): void
    {
        $payer = self::findHolder($transactionDTO->payer_id);
        $payee = self::findHolder($transactionDTO->payer_id);

        if (!$payer) {
            throw TransactionException::payerNotFound();
        }

        if (!$payee) {
            throw TransactionException::payeeNotFound();
        }

        if (get_class($payer) == Seller::class) {
            throw TransactionException::sellersCantSendMoney();
        }

        if ($payer->wallet->balance < $transactionDTO->amount) {
            throw TransactionException::insufficientFunds();
        }
    }

    private static function findHolder($holderId): Customer | Seller | false
    {
        if ($customer = Customer::find($holderId)) {
            return $customer;
        }

        if ($seller = Seller::find($holderId)) {
            return $seller;
        }

        return false;
    }
}
