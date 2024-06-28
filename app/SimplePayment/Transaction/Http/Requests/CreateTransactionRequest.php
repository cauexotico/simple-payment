<?php

namespace SimplePayment\Transaction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SimplePayment\Transaction\DTO\TransactionDTO;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payer_id' => 'required|uuid',
            'payee_id' => 'required|uuid',
            'amount' => 'required|integer|min:0',
        ];
    }

    public function toDTO(): TransactionDTO
    {
        return new TransactionDTO(
            payer_id: $this->input('payer_id'),
            payee_id: $this->input('payee_id'),
            amount: $this->input('amount'),
        );
    }
}
