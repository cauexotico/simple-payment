<?php

namespace SimplePayment\Customer;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use SimplePayment\Transaction\Transaction;
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
     * Get all of the customer's transactions.
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'payer');
    }

    /**
     * Get the Customer factory.
     */
    protected static function newFactory(): CustomerFactory
    {
        return CustomerFactory::new();
    }
}
