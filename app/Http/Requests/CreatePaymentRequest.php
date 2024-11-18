<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
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
            'customer' => 'required|exists:customers,asaas_id',
            'value' => 'required|numeric|min:0',
            'billingType' => 'required|string|in:CREDIT_CARD,boleto',
            'dueDate' => 'required|date|after_or_equal:today',
            // Adicione outras regras conforme necessário
        ];
    }
}
