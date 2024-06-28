<?php

return [
    App\Providers\AppServiceProvider::class,
    \SimplePayment\User\UserRouteProvider::class,
    \SimplePayment\Transaction\TransactionRouteProvider::class,
    \SimplePayment\PaymentGateways\PaymentGatewayServiceProvider::class,
];
