<?php

namespace App\Http\Requests\Exams;

use Illuminate\Foundation\Http\FormRequest;

class HealthRequest extends FormRequest
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
            'height' => ['required', 'numeric'],
            'weight' => ['required', 'numeric'],
            'blood_type' => ['required', 'string', 'max:255'],
            'blood_pressure' => ['required', 'string', 'max:255'],
            'blood_sugar' => ['required', 'string', 'max:255'],
            'is_smoking' => ['required', 'boolean'],
            'color_blind' => ['required', 'boolean'],
            'is_disability' => ['required', 'boolean'],
            'note' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'extensions:jpg,png'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute ini tidak boleh kosong',
            'height.numeric' => 'Tinggi badan harus berupa angka',
            'weight.numeric' => 'Berat badan harus berupa angka',
            'blood_type.string' => 'Golongan darah harus berupa text',
            'blood_pressure.string' => 'Tekanan darah harus berupa text',
            'blood_sugar.string' => 'Gula darah harus berupa text',
            'is_smoking.boolean' => 'Merokok harus berupa Iya/Tidak',
            'color_blind.boolean' => 'Buta warna harus berupa Iya/Tidak',
            'is_disability.boolean' => 'Disabilitas harus berupa Iya/Tidak',
            'history_of_disease.string' => 'Riwayat penyakit harus berupa text',
            'note.string' => 'Catatan harus berupa text',
            'image.image' => 'Harus berupa gambar',
            'image.extensions' => 'Harus berupa gambar dengan ekstensi jpg atau png',

        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'height' => 'Tinggi badan',
            'weight' => 'Berat badan',
            'blood_type' => 'Golongan darah',
            'blood_pressure' => 'Tekanan darah',
            'blood_sugar' => 'Gula darah',
            'is_smoking' => 'Perokok',
            'color_blind' => 'Buta warna',
            'is_disability' => 'Disabilitas',
            'note' => 'Catatan',
            'image' => 'Bukti pemeriksaan kesehatan',
        ];
    }

}
