<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamQuestionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     if ($this->user()->hasRole('admin')) {
    //         return true;
    //     }
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question' => ['required', 'string'],
            'answer' => ['required', 'string', 'in:A,B,C,D,E'],
            'option_a' => ['nullable', 'string'],
            'option_b' => ['nullable', 'string'],
            'option_c' => ['nullable', 'string'],
            'option_d' => ['nullable', 'string'],
            'option_e' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan harus diisi',
            'answer.required' => 'Jawaban harus diisi',
            'answer.in' => 'Jawaban hanya berisi: A, B, C, D, E',
        ];
    }
}
