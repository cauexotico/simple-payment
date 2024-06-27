<?php

namespace Tests\Feature;

use Tests\TestCase;
use SimplePayment\Notifications\Providers\Mock02\Mock02Client;

class Mock02NotifyTest extends TestCase
{
    /**
     * Tests if the external service Mock02 can notify users
     */
    public function test_mock02_can_notify_users(): void
    {
        $notifyClient = new Mock02Client;

        $this->assertIsBool($notifyClient->notify());
    }
}
