<?php

namespace SimplePayment\Notifications;

use Exception;

class NotificationException extends Exception
{
    public static function requestError(string $gatewayName): self
    {
        return new self('An error occurred while processing your request using the notification provider ' . $gatewayName);
    }

    public static function unknowGateway(string $gatewayName): self
    {
        return new self('We not recognize the ' . $gatewayName . ' provider');
    }
}
