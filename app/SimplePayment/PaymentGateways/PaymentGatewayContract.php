<?php

namespace SimplePayment\PaymentGateways;

interface PaymentGatewayContract
{
    public function getName(): string;
    public function paymentAuthorized(): bool;
}
