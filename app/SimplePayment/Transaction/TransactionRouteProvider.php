<?php

namespace SimplePayment\Transaction;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use SimplePayment\Transaction\Http\Controllers\TransactionController;

class TransactionRouteProvider extends RouteServiceProvider
{
    public function map(): void
    {
        Route::post(
            '/api/transaction',
            [TransactionController::class, 'createTransaction']
        )->name('transactions.store');
    }
}
