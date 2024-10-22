<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use SimplePayment\Seller\Seller;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if users can be created
     */
    public function test_users_can_be_created_using_api(): void
    {
        $response = $this->postJson(route('users.store'), [
            'name' => 'John Doe',
            'email' => 'john@acme.com',
            'document' => '00000000000000',
            'type' => 'seller',
            'password' => '12345678',
        ]);

        $response->assertStatus(201);
    }

    /**
     * Tests if users cannot be created with wrong params
     */
    public function test_cannot_duplicate_users(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@acme.com',
            'document' => '00000000000000',
            'type' => 'seller',
            'password' => '12345678',
        ];

        $response = $this->postJson(route('users.store'), $data);
        $response->assertStatus(201);

        $response = $this->postJson(route('users.store'), $data);
        $response->assertStatus(422);
    }

    /**
     * Tests if created users have holder and wallets
     */
    public function test_users_have_holder_and_wallet(): void
    {
        $response = $this->postJson(route('users.store'), [
            'name' => 'John Doe',
            'email' => 'john@acme.com',
            'document' => '00000000000000',
            'type' => 'seller',
            'password' => '12345678',
        ]);

        $this->assertDatabaseHas('sellers', [
            'user_id' => $response->json('id'),
        ]);

        $seller = Seller::where('user_id', $response->json('id'))->first();

        $this->assertDatabaseHas('wallets', [
            'holder_id' => $seller->id,
            'holder_type' => Seller::class,
        ]);
    }
}
