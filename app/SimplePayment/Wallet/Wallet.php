<?php

namespace SimplePayment\Wallet;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'balance',
        'blocked_balance',
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
            'blocked_balance' => 'integer',
        ];
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
