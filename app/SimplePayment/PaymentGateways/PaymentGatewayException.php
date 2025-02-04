<?php

namespace SimplePayment\PaymentGateways;

use Exception;

class PaymentGatewayException extends Exception
{
    public static function requestError(string $gatewayName): self
    {
        return new self('An error occurred while processing your request using the gateway ' . $gatewayName);
    }

    public static function unknowGateway(string $gatewayName): self
    {
        return new self('We not recognize the ' . $gatewayName . ' provider');
    }
}
