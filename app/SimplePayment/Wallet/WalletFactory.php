<?php

namespace SimplePayment\Wallet;

use Illuminate\Database\Eloquent\Factories\Factory;
use SimplePayment\Customer\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'balance' => 0,
            'holder_id' => Customer::factory(),
            'holder_type' => Customer::class,
        ];
    }

    /**
     * Indicate that the wallet should belong to a specific holder.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forHolder($holder)
    {
        return $this->state(function () use ($holder) {
            return [
                'holder_id' => $holder->getKey(),
                'holder_type' => get_class($holder),
            ];
        });
    }
}
