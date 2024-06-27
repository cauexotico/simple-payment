<?php

namespace SimplePayment\Seller;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use SimplePayment\Seller\SellerFactory;
use SimplePayment\Transaction\Transaction;
use SimplePayment\Wallet\Wallet;

class Seller extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'document',
    ];

    /**
     * Get the User associated with the Seller.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Seller's wallet.
     */
    public function wallet(): MorphOne
    {
        return $this->morphOne(Wallet::class, 'holder');
    }

    /**
     * Get all of the seller's transactions.
     */
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'payer');
    }

    /**
     * Get the Seller factory.
     */
    protected static function newFactory(): SellerFactory
    {
        return SellerFactory::new();
    }
}
