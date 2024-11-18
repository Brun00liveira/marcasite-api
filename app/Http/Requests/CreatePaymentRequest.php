<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer essa requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtenha as regras de validação que devem ser aplicadas à requisição.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'billingType' => 'required|string|in:CREDIT_CARD,boleto',
            'value' => 'required|numeric|min:0',
            'dueDate' => 'required|date|after_or_equal:today',
            'creditCard' => 'required_if:billingType,CREDIT_CARD|array',
            'creditCard.holderName' => 'required_if:billingType,CREDIT_CARD|string|max:255',
            'creditCard.number' => 'required_if:billingType,CREDIT_CARD|regex:/^\d{16}$/',
            'creditCard.expiryMonth' => 'required_if:billingType,CREDIT_CARD|digits:2|between:01,12',
            'creditCard.expiryYear' => 'required_if:billingType,CREDIT_CARD|digits:4|after_or_equal:' . date('Y'),
            'creditCard.ccv' => 'required_if:billingType,CREDIT_CARD|regex:/^\d{3,4}$/',
            'creditCardHolderInfo' => 'required_if:billingType,CREDIT_CARD|array',
            'creditCardHolderInfo.name' => 'required_if:billingType,CREDIT_CARD|string|max:255',
            'creditCardHolderInfo.email' => 'required_if:billingType,CREDIT_CARD|email|max:255',
            'creditCardHolderInfo.cpfCnpj' => 'required_if:billingType,CREDIT_CARD',
            'creditCardHolderInfo.postalCode' => 'required_if:billingType,CREDIT_CARD|regex:/^\d{5}-\d{3}$/',
            'creditCardHolderInfo.addressNumber' => 'required_if:billingType,CREDIT_CARD|string|max:255',
            'creditCardHolderInfo.addressComplement' => 'nullable|string|max:255',
            'creditCardHolderInfo.phone' => 'required_if:billingType,CREDIT_CARD|regex:/^\d{10,15}$/',
            'creditCardHolderInfo.mobilePhone' => 'required_if:billingType,CREDIT_CARD|regex:/^\d{10,15}$/',

        ];
    }
}
