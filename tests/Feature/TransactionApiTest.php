<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use SimplePayment\Seller\Seller;
use SimplePayment\Wallet\Wallet;
use Tests\TestCase;

class TransactionApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_send_money(): void
    {
        $payer = Wallet::factory([
            'balance' => 100_00
        ])->create();

        $payee = Wallet::factory([
            'balance' => 0
        ])->create();

        $response = $this->postJson(route('transactions.store'), [
            'payer_id' => $payer->holder->getKey(),
            'payee_id' => $payee->holder->getKey(),
            'amount' => 1_00,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('wallets', [
            'holder_id' => $payee->holder->getKey(),
            'balance' => 1_00,
        ]);
    }

    public function test_user_cannot_send_more_than_they_have(): void
    {
        $payer = Wallet::factory([
            'balance' => 0_00
        ])->create();
        $payee = Wallet::factory()->create();

        $response = $this->postJson(route('transactions.store'), [
            'payer_id' => $payer->holder->id,
            'payee_id' => $payee->holder->id,
            'amount' => 1_00,
        ]);

        $response->assertStatus(422);
    }

    public function test_sellers_cannot_send_money(): void
    {
        $payer = Wallet::factory(['balance' => 100_00])
            ->forHolder(Seller::factory()->create())
            ->create();

        $payee = Wallet::factory()->create();

        $response = $this->postJson(route('transactions.store'), [
            'payer_id' => $payer->holder->id,
            'payee_id' => $payee->holder->id,
            'amount' => 1_00,
        ]);

        $response->assertStatus(422);
    }

    public function test_inexistent_users_cannot_send_money(): void
    {
        $response = $this->postJson(route('transactions.store'), [
            'payer_id' => Str::uuid(),
            'payee_id' => Str::uuid(),
            'amount' => 1_00,
        ]);

        $response->assertStatus(422);
    }
}
