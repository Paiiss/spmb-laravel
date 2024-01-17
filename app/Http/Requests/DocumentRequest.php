<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'ktp' => ['extensions:jpg,png', 'image', 'nullable'],
            'foto' => ['nullable', 'image', 'extensions:jpg,png'],
            'ijazah' => ['nullable', 'image', 'extensions:jpg,png'],
            'transkrip_nilai' => ['nullable', 'image', 'extensions:jpg,png'],

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'ktp.extensions' => 'KTP harus berupa file jpg atau png',
            'foto.extensions' => 'Foto harus berupa file jpg atau png',
            'ijazah.extensions' => 'Ijazah harus berupa file pdf',
            'transkrip_nilai.extensions' => 'Transkrip nilai harus berupa file pdf',
        ];
    }
}
