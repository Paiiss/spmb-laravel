<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /* public function authorize(): bool
    {
        return false;
    } */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'name' => ['string', 'max:255'],
            'gender' => ['string', 'max:255', 'nullable'],
            'religion' => ['string', 'max:255', 'nullable'],
            'birth_date' => ['date', 'nullable'],
            'birth_place_city' => ['string', 'max:255', 'nullable'],
            'birth_place_province' => ['string', 'max:255', 'nullable'],
            'birth_place_country' => ['string', 'max:255', 'nullable'],
            'national_id' => ['string', 'nullable'],
            'is_color_blind' => ['boolean', 'nullable',],
            'is_disability' => ['boolean', 'nullable'],
            'disability_note' => ['string', 'max:255', 'nullable'],
            'address' => ['string', 'max:255', 'nullable'],
            'city' => ['string', 'max:255', 'nullable'],
            'province' => ['string', 'max:255', 'nullable'],
            'subdistrict' => ['string', 'max:255', 'nullable'],
            'country' => ['string', 'max:255', 'nullable'],
            'postal_code' => ['integer', 'nullable'],
            'rt' => ['string', 'nullable'],
            'rw' => ['string', 'nullable'],
            'phone_number' => ['string', 'max:255', 'nullable'],
            'phone_number_alt' => ['string', 'max:255', 'nullable'],
            'last_education' => ['string', 'max:255', 'nullable'],
            'education_number' => ['string', 'nullable'],
            'education_name' => ['string', 'max:255', 'nullable'],
            'education_city' => ['string', 'max:255', 'nullable'],
            'education_province' => ['string', 'max:255', 'nullable'],
            'education_subdistrict' => ['string', 'max:255', 'nullable'],
            'education_country' => ['string', 'max:255', 'nullable'],
            'education_postal_code' => ['string', 'nullable'],
            'education_graduation_year' => ['string', 'max:255', 'nullable'],
            'education_major' => ['string', 'max:255', 'nullable'],
            'education_grade' => ['numeric', 'min:1', 'max:100', 'nullable'],
            'father_name' => ['string', 'max:255', 'nullable'],
            'father_birth_date' => ['date', 'nullable'],
            'father_place' => ['string', 'max:255', 'nullable'],
            'father_last_education' => ['string', 'max:255', 'nullable'],
            'father_job' => ['string', 'max:255', 'nullable'],
            'father_phone' => ['string', 'max:255', 'nullable'],
            'father_email' => ['string', 'max:255', 'nullable'],
            'mother_name' => ['string', 'max:255', 'nullable'],
            'mother_birth_date' => ['date', 'nullable'],
            'mother_place' => ['string', 'max:255', 'nullable'],
            'mother_last_education' => ['string', 'max:255', 'nullable'],
            'mother_job' => ['string', 'max:255', 'nullable'],
            'mother_email' => ['string', 'max:255', 'nullable'],
            'mother_phone' => ['string', 'max:255', 'nullable'],
            'guardian_name' => ['string', 'max:255', 'nullable'],
            'guardian_birth_date' => ['date', 'nullable'],
            'guardian_place' => ['string', 'max:255', 'nullable'],
            'guardian_last_education' => ['string', 'max:255', 'nullable'],
            'guardian_job' => ['string', 'max:255', 'nullable'],
            'guardian_email' => ['string', 'max:255', 'nullable'],
            'guardian_phone' => ['string', 'max:255', 'nullable'],
            'guardian_relation' => ['string', 'max:255', 'nullable'],

            // 'wave_id' => ['integer', 'required'],
            // 'option' => ['integer', 'required'],
            // 'option_2' => ['integer', 'nullable'],


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
            'min' => 'Nilai :attribute minimal :min',
            'max' => 'Nilai :attribute maksimal :max',
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
            'gender' => 'jenis kelamin',
            'religion' => 'agama',
            'birth_date' => 'tanggal lahir',
            'birth_place_city' => 'kota tempat lahir',
            'birth_place_province' => 'provinsi tempat lahir',
            'birth_place_country' => 'negara tempat lahir',
            'national_id' => 'nomor KTP',
            'is_color_blind' => 'buta warna',
            'is_disability' => 'disabilitas',
            'disability_note' => 'catatan disabilitas',
            'address' => 'alamat',
            'city' => 'kota',
            'province' => 'provinsi',
            'subdistrict' => 'kecamatan',
            'country' => 'negara',
            'postal_code' => 'kode pos',
            'rt' => 'RT',
            'rw' => 'RW',
            'phone_number' => 'nomor telepon',
            'phone_number_alt' => 'nomor telepon alternatif',
            'last_education' => 'pendidikan terakhir',
            'education_number' => 'nisn',
            'education_name' => 'nama sekolah',
            'education_city' => 'kota sekolah',
            'education_province' => 'provinsi sekolah',
            'education_subdistrict' => 'kecamatan sekolah',
            'education_country' => 'negara sekolah',
            'education_postal_code' => 'kode pos sekolah',
            'education_graduation_year' => 'tahun lulus',
            'education_major' => 'jurusan',
            'education_grade' => 'nilai rata-rata',
            'father_name' => 'nama ayah',
            'father_birth_date' => 'tanggal lahir ayah',
            'father_place' => 'tempat lahir ayah',
            'father_last_education' => 'pendidikan terakhir ayah',
            'father_job' => 'pekerjaan ayah',
            'father_phone' => 'nomor telepon ayah',
            'father_email' => 'email ayah',
            'mother_name' => 'nama ibu',
            'mother_birth_date' => 'tanggal lahir ibu',
            'mother_place' => 'tempat lahir ibu',
            'mother_last_education' => 'pendidikan terakhir ibu',
            'mother_job' => 'pekerjaan ibu',
            'mother_email' => 'email ibu',
            'mother_phone' => 'nomor telepon ibu',
            'guardian_name' => 'nama wali',
            'guardian_birth_date' => 'tanggal lahir wali',
            'guardian_place' => 'tempat lahir wali',
            'guardian_last_education' => 'pendidikan terakhir wali',
            'guardian_job' => 'pekerjaan wali',
            'guardian_email' => 'email wali',
            'guardian_phone' => 'nomor telepon wali',
            'affiliate_id' => 'afiliasi',

        ];
    }
}
