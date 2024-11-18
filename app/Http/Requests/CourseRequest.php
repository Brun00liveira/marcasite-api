<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'is_active' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['title'] = 'nullable|string|max:255';
            $rules['description'] = 'nullable|string';
            $rules['price'] = 'nullable|numeric';
            $rules['category_id'] = 'nullable|numeric';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título do curso é obrigatório.',
            'title.string' => 'O título deve ser uma string.',
            'title.max' => 'O título deve ter no máximo 255 caracteres.',

            'description.required' => 'A descrição é obrigatória.',

            'price.required' => 'O preço do curso é obrigatório.',

            'photo.image' => 'A foto deve ser uma imagem.',
            'photo.max' => 'A foto não pode ultrapassar 2MB.',

            'category_id.exists' => 'O "category_id" informado não é válido. Verifique se o ID existe na tabela de categorias.',
        ];
    }
}
