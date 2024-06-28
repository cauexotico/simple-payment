<?php

namespace SimplePayment\Transaction\Services;

use SimplePayment\Customer\Customer;
use SimplePayment\Enums\TransactionStatus;
use SimplePayment\Seller\Seller;
use SimplePayment\Transaction\DTO\TransactionDTO;
use SimplePayment\Transaction\Transaction;
use SimplePayment\Transaction\TransactionException;
use Illuminate\Support\Facades\DB;
use SimplePayment\Notifications\NotificationContract;
use SimplePayment\PaymentGateways\PaymentGatewayContract;
use SimplePayment\Transaction\Repositories\TransactionRepository;

class TransactionService
{
    public function __construct(
        private readonly PaymentGatewayContract $paymentGateway,
        private readonly NotificationContract $notificationGateway,
        private readonly TransactionRepository $transactionRepository,
    ) {
    }

    public function createTransaction(TransactionDTO $transactionDTO): Transaction
    {
        $payer = $this->findHolder($transactionDTO->payer_id);
        $payee = $this->findHolder($transactionDTO->payee_id);

        $this->validateTransactionRequirements($transactionDTO, $payer, $payee);

        return DB::transaction(function () use ($transactionDTO, $payer, $payee) {

            $transaction = $this->transactionRepository->createTransaction($transactionDTO, $payer, $payee);

            if (!$this->paymentGateway->paymentAuthorized()) {
                throw TransactionException::notAuthorized($this->paymentGateway);
            }

            $transaction->setStatus(TransactionStatus::APPROVED);

            $transaction = $this->transactionRepository->transferMoney($transaction);

            $transaction->setStatus(TransactionStatus::FINISHED);

            if (!$this->notificationGateway->notify()) {
                throw TransactionException::unableToNotify($this->notificationGateway);
            }

            $transaction->setStatus(TransactionStatus::NOTIFIED);

            return $transaction;
        });
    }

    private static function validateTransactionRequirements(TransactionDTO $transactionDTO, $payer = null, $payee = null): void
    {
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
