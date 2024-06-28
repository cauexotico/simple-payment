<?php

namespace SimplePayment\Notifications;

use Illuminate\Support\ServiceProvider;
use SimplePayment\Notifications\Providers\Mock02\Mock02Client;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(NotificationContract::class, function () {
            return match (config('payments.notification')) {
                'mock02' => new Mock02Client(),
                default => throw NotificationException::unknowGateway(config('payments.notification')),
            };
        });
    }
}
