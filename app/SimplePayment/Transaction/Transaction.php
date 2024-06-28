<?php

namespace SimplePayment\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use SimplePayment\Enums\TransactionStatus;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'payer_id',
        'payer_type',
        'payee_id',
        'payee_type',
        'amount',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'status' => TransactionStatus::class,
        ];
    }

    public function setStatus(TransactionStatus $status)
    {
        $this->status = $status;
        $this->save();
    }

    /**
     * Get the who paid.
     */
    public function payer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get who received.
     */
    public function payee(): MorphTo
    {
        return $this->morphTo();
    }
}
