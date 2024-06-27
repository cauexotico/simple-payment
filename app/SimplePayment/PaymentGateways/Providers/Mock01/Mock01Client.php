<?php

namespace SimplePayment\PaymentGateways\Providers\Mock01;

use Illuminate\Support\Facades\Http;
use SimplePayment\PaymentGateways\PaymentGatewayContract;
use SimplePayment\PaymentGateways\PaymentGatewayException;

class Mock01Client implements PaymentGatewayContract
{
    private const GATEWAY_URL = 'https://run.mocky.io/v3/4a9ebf69-e2df-448d-b7d5-7bd5a3fa3f62';

    public function getName(): string
    {
        return 'Mock 01';
    }

    public function paymentAuthorized(): bool
    {
        if (config('external.ignore_external_services')) {
            return true;
        }

        $response = Http::retry(3, 100)->get(self::GATEWAY_URL);

        if ($response->failed()) {
            throw PaymentGatewayException::requestError(self::getName());
        }

        return $response->json('message') == 'Autorizado';
    }
}
