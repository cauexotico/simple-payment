<?php

namespace Tests\Feature;

use App\Models\User;
use SimplePayment\Customer\Customer;
use SimplePayment\Seller\Seller;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Tests if users can be created
     */
    public function test_users_can_be_created_using_factory(): void
    {
        $customer = Customer::factory()->create();
        $seller = Seller::factory()->create();

        // Testing Customer
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $customer->user->id,
        ]);

        $this->assertInstanceOf(User::class, $customer->user);
        $this->assertNotNull($customer->user->id);

        // Testing Seller
        $this->assertDatabaseHas('sellers', [
            'id' => $seller->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $seller->user->id,
        ]);

        $this->assertInstanceOf(User::class, $seller->user);
        $this->assertNotNull($seller->user->id);
    }
}
