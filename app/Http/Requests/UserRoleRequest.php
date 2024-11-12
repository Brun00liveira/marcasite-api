<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRoleRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|exists:roles,name',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo de ID do usuário é obrigatório.',
            'user_id.exists' => 'O usuário com o ID fornecido não existe.',
            'role.required' => 'O campo de função é obrigatório.',
            'role.exists' => 'A função fornecida não existe.',
        ];
    }
}
