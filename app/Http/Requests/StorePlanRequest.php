<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Verifica se o método é PUT ou PATCH
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            return [
                'name'  => 'nullable|string|max:255', // O nome é obrigatório
                'price' => 'nullable|numeric|min:0',  // O preço é obrigatório
                'description' => 'nullable'
            ];
        }

        // Caso contrário, talvez você tenha regras diferentes, como validação para criação
        return [
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do plano é obrigatório.',
            'price.required' => 'O preço do plano é obrigatório.',
            'price.numeric' => 'O preço deve ser um valor numérico.',
            'price.min' => 'O preço deve ser um valor maior ou igual a zero.',
        ];
    }
}
