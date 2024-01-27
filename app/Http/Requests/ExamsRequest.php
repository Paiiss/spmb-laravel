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
        if ($this->user()->hasRole('admin')) {
            return true;
        }
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
            'description' => ['nullable', 'string'],
            'duration' => ['required', 'integer'],
            'allowed' => ['nullable', 'json'],
            'shuffle_question' => ['required', 'boolean'],
            'shuffle_answer' => ['required', 'boolean'],
            'show_result' => ['required', 'boolean'],
            'access_start_time' => ['required', 'regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'access_end_time' => ['required', 'regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi.',
            'string' => ':attribute harus berupa text/kata.',
            'max' => ':attribute tidak boleh lebih dari :max karakter.',
            'integer' => ':attribute harus berupa angka.',
            'boolean' => ':attribute harus berupa Ya/Tidak.',
            'H:i' => ':attribute harus berupa format jam:menit.',
            'array' => ':attribute harus berupa array.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Ujian',
            'description' => 'Deskripsi Ujian',
            'duration' => 'Durasi Ujian',
            'allowed' => 'Prodi yang diizinkan',
            'shuffle_question' => 'Acak pertanyaan',
            'shuffle_answer' => 'Acak jawaban',
            'show_result' => 'Tampilkan hasil',
            'access_start_time' => 'Waktu mulai akses',
            'access_end_time' => 'Waktu akhir akses',
            'is_active' => 'Aktif',
        ];
    }
}
