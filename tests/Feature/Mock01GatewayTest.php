<?php

namespace Tests\Feature;

use Tests\TestCase;
use SimplePayment\PaymentGateways\Providers\Mock01\Mock01Client;

class Mock01GatewayTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_mock01_can_authorize_payments(): void
    {
        $paymentGateway = new Mock01Client;

        $this->assertIsBool($paymentGateway->paymentAuthorized());
    }
}
