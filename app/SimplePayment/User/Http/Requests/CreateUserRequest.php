<?php

namespace SimplePayment\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SimplePayment\Enums\UserType;
use SimplePayment\User\DTO\UserDTO;

class CreateUserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'document' => 'required|string|size:11|unique:customers',
            'type' => ['required', Rule::enum(UserType::class)],
            'password' => 'required|string|min:8',
        ];

        if ($this->input('type') == UserType::SELLER->value) {
            $rules['document'] = 'required|string|size:14|unique:sellers';
        }

        return $rules;
    }

    public function toDTO(): UserDTO
    {
        return new UserDTO(
            name: $this->input('name'),
            email: $this->input('email'),
            document: $this->input('document'),
            type: $this->input('type'),
            password: $this->input('password'),
        );
    }
}
