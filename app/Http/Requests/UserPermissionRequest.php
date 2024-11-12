<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPermissionRequest extends FormRequest
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
            'permission' => 'required|string|exists:permissions,name',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'O campo de ID do usuário é obrigatório.',
            'user_id.exists' => 'O usuário com o ID fornecido não existe.',
            'permission.required' => 'O campo de função é obrigatório.',
            'permission.exists' => 'A função fornecida não existe.',
        ];
    }
}
