<?php

namespace SimplePayment\PaymentGateways;

use Illuminate\Support\ServiceProvider;
use SimplePayment\PaymentGateways\Providers\Mock01\Mock01Client;

class PaymentGatewayServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(PaymentGatewayContract::class, function () {
            return match (config('payments.gateway')) {
                'mock01' => new Mock01Client(),
            };
        });
    }
}
