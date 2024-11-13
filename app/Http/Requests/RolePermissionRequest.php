<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolePermissionRequest extends FormRequest
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
            'role' => 'required|string|exists:roles,name',
            'permission' => 'required|string|exists:permissions,name',
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'O campo de função é obrigatório.',
            'role.exists' => 'A função fornecida não existe.',

            'permission.required' => 'O campo de permissão é obrigatório.',
            'permission.exists' => 'A permissão fornecida não existe.',
        ];
    }
}
