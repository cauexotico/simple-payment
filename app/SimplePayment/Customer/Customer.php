<?php

namespace SimplePayment\Customer;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use SimplePayment\Wallet\Wallet;

class Customer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'document',
    ];

    /**
     * Get the User associated with the Customer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Customer's wallet.
     */
    public function wallet(): MorphOne
    {
        return $this->morphOne(Wallet::class, 'holder');
    }

    /**
     * Get the Customer factory.
     */
    protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }
}