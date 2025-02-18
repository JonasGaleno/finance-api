<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetRegisterRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id|integer',
            'category_id' => 'required|exists:categories,id|integer',
            'limit_amount' => 'required|numeric|min:0',
            'month' => 'required|string|in:january,february,march,april,may,june,july,august,september,october,november,december',
            'year' => 'required|digits:4|integer|min:' . date('Y'),
        ];
    }
}
