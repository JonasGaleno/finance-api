<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'description' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id|integer',
            'category_id' => 'required|exists:categories,id|integer',
            'payment_method_id' => 'required|exists:payment_methods,id|integer',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|string|in:income,expense',
            'transaction_date' => 'required|date',
        ];
    }
}
