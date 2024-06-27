<?php

namespace Tests\Feature;

use Tests\TestCase;
use SimplePayment\PaymentGateways\Providers\Mock01\Mock01Client;

class Mock01GatewayTest extends TestCase
{
    /**
     * Tests if the external service Mock01 can authorize payments
     */
    public function test_mock01_can_authorize_payments(): void
    {
        $paymentGateway = new Mock01Client;

        $this->assertIsBool($paymentGateway->paymentAuthorized());
    }
}
