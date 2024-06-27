<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SimplePayment\Enums\TransactionStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('payer');
            $table->uuidMorphs('payee');
            $table->unsignedBigInteger('amount');
            $table->enum('status', TransactionStatus::toArray())->default(TransactionStatus::PENDING);
            $table->foreignUuid('related_transaction_id')->nullable()->constrained('transactions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
