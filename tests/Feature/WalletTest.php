<?php

namespace Tests\Feature;

use SimplePayment\Customer\Customer;
use SimplePayment\Seller\Seller;
use SimplePayment\Wallet\Wallet;
use Tests\TestCase;

class WalletTest extends TestCase
{
    /**
     * Tests if wallets can be created
     */
    public function test_wallets_can_be_created_using_factory(): void
    {
        $seller = Seller::factory()->create();

        $wallet = Wallet::factory()->forHolder($seller)->create();

        $this->assertDatabaseHas('wallets', [
            'id' => $wallet->id,
            'holder_id' => $seller->id,
            'holder_type' => get_class($seller),
        ]);

        $this->assertInstanceOf(Seller::class, $wallet->holder);
    }

    /**
     * Tests if wallets can be created without holder
     */
    public function test_wallets_can_be_created_without_specify_holder(): void
    {
        $wallet = Wallet::factory()->create();

        $this->assertDatabaseHas('wallets', [
            'id' => $wallet->id,
        ]);

        $this->assertInstanceOf(Customer::class, $wallet->holder);
    }
}
