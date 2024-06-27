<?php

namespace SimplePayment\Seller;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use SimplePayment\Seller\Seller;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SellerFactory extends Factory
{
    protected $model = Seller::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'document' => $this->faker->unique()->numerify('##############'),
            'user_id' => User::factory(),
        ];
    }
}
