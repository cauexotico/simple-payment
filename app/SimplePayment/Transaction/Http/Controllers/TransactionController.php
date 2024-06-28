<?php

namespace SimplePayment\Transaction\Http\Controllers;

use App\Http\Controllers\Controller;
use SimplePayment\Transaction\Http\Requests\CreateTransactionRequest;
use SimplePayment\Transaction\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(
        private readonly TransactionService $transactionService
    ) {
    }

    public function createTransaction(CreateTransactionRequest $request)
    {
        return $this->transactionService->createTransaction($request->toDTO());
    }
}
