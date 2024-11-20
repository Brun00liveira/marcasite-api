<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnrollmentRequest extends FormRequest
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
        $rules = [
            'course_id' => [
                'required',
                'exists:courses,id',
                Rule::unique('enrollments')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],

            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,active,completed,cancelled',
            'enrolled_at' => 'nullable|date',
            'completed_at' => 'nullable|date|after_or_equal:enrolled_at',
            'progress' => 'nullable|integer|min:0|max:100',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {

            $rules['status'] = 'nullable|in:pending,active,completed,cancelled';
            $rules['enrolled_at'] = 'nullable|date';
            $rules['completed_at'] = 'nullable|date|after_or_equal:enrolled_at'; // Garantir que completed_at seja após enrolled_at
            $rules['progress'] = 'nullable|integer|min:0|max:100';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'course_id.required' => 'O curso é obrigatório.',
            'course_id.exists' => 'O curso selecionado não existe.',

            'user_id.required' => 'O usuário é obrigatório.',
            'user_id.exists' => 'O usuário selecionado não existe.',

            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser um dos seguintes: pending, active, completed, cancelled.',

            'enrolled_at.date' => 'A data de matrícula deve ser uma data válida.',

            'completed_at.date' => 'A data de conclusão deve ser uma data válida.',
            'completed_at.after_or_equal' => 'A data de conclusão deve ser posterior ou igual à data de matrícula.',

            'progress.integer' => 'O progresso deve ser um número inteiro.',
            'progress.min' => 'O progresso deve ser no mínimo 0.',
            'progress.max' => 'O progresso não pode ser superior a 100.',
        ];
    }
}
