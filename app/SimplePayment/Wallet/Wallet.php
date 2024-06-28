<?php

namespace SimplePayment\Wallet;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'payer_id',
        'payee_id',
        'balance',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'balance' => 'integer',
        ];
    }

    public function addBalance(int $amount): void
    {
        if ($amount < 0) $amount = 0;

        $this->balance += $amount;
        $this->save();
    }

    public function removeBalance(int $amount): void
    {
        if ($amount < 0) $amount = 0;

        $this->balance -= $amount;
        $this->save();
    }

    /**
     * Get the holder of the Wallet.
     */
    public function holder(): BelongsTo
    {
        return $this->morphTo();
    }

    /**
     * Get the Wallet factory.
     */
    protected static function newFactory(): WalletFactory
    {
        return WalletFactory::new();
    }
}
