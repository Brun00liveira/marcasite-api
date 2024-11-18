<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
        // Regras padrão para criação
        $rules = [
            'name' => 'required|string|max:255',
            'cpfCnpj' => 'required|string|max:14|unique:customers',
            'email' => 'required|email|unique:customers',
            'phone' => 'required|string|max:15|unique:customers',
        ];

        // Condicional para PUT/PATCH (edição)
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = 'nullable|string|max:255';
            $rules['cpfCnpj'] = 'nullable|string|max:14|unique:customers,cpfCnpj,' . $this->route('customer'); // Ignora a verificação de unicidade para o próprio CPF/CNPJ
            $rules['email'] = 'nullable|email|unique:customers,email,' . $this->route('customer'); // Ignora a verificação de unicidade para o próprio e-mail
            $rules['phone'] = 'nullable|string|max:15|unique:customers,phone,' . $this->route('customer'); // Ignora a verificação de unicidade para o próprio telefone
        }

        return $rules;
    }
}
