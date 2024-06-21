<?php

namespace SimplePayment\Notifications\Providers\Mock02;

use Illuminate\Support\Facades\Http;
use SimplePayment\Notifications\NotificationContract;
use SimplePayment\Notifications\NotificationException;

class Mock02Client implements NotificationContract
{
    private const NOTIFICATION_URL = 'https://run.mocky.io/v3/1875b264-8fdb-4707-aa52-5ac1d120ac07';

    public function getName(): string
    {
        return 'Mock 02';
    }

    public function notify(): bool
    {
        $response = Http::retry(3, 100)->get(self::NOTIFICATION_URL);

        if ($response->failed()) {
            throw NotificationException::requestError(self::getName());
        }

        return $response->json('message') == 'Notificação enviada';
    }
}
