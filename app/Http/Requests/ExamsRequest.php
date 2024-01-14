<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama soal harus diisi',
            'duration.required' => 'Durasi soal harus diisi',
            'is_active.required' => 'Status aktif soal harus diisi',
        ];
    }
}
