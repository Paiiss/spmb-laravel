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
            'gender' => ['string', 'max:255'],
            'religion' => ['string', 'max:255'],
            'birth_date' => ['date'],
            'birth_place_city' => ['string', 'max:255'],
            'birth_place_province' => ['string', 'max:255'],
            'birth_place_country' => ['string', 'max:255'],
            'national_id' => ['integer'],
            'is_color_blind' => ['boolean'],
            'is_disability' => ['boolean'],
            'disability_note' => ['string', 'max:255', 'nullable'],
            'address' => ['string', 'max:255', 'nullable'],
            'city' => ['string', 'max:255'],
            'province' => ['string', 'max:255'],
            'subdistrict' => ['string', 'max:255'],
            'country' => ['string', 'max:255'],
            'postal_code' => ['integer'],
            'rt' => ['integer'],
            'rw' => ['integer'],
            'phone_number' => ['string', 'max:255'],
            'phone_number_alt' => ['string', 'max:255'],
            'last_education' => ['string', 'max:255', 'nullable'],
            'education_number' => ['integer', 'nullable'],
            'education_name' => ['string', 'max:255', 'nullable'],
            'education_city' => ['string', 'max:255', 'nullable'],
            'education_province' => ['string', 'max:255', 'nullable'],
            'education_subdistrict' => ['string', 'max:255', 'nullable'],
            'education_country' => ['string', 'max:255', 'nullable'],
            'education_postal_code' => ['integer', 'nullable'],
            'education_graduation_year' => ['string', 'max:255', 'nullable'],
            'education_major' => ['string', 'max:255', 'nullable'],
            'education_grade' => ['string', 'max:255', 'nullable'],
            'father_name' => ['string', 'max:255'],
            'father_birth_date' => ['date'],
            'father_place' => ['string', 'max:255'],
            'father_last_education' => ['string', 'max:255'],
            'father_job' => ['string', 'max:255'],
            'father_phone' => ['string', 'max:255'],
            'father_email' => ['string', 'max:255'],
            'mother_name' => ['string', 'max:255'],
            'mother_birth_date' => ['date'],
            'mother_place' => ['string', 'max:255'],
            'mother_last_education' => ['string', 'max:255'],
            'mother_job' => ['string', 'max:255'],
            'mother_email' => ['string', 'max:255'],
            'mother_phone' => ['string', 'max:255'],
            'guardian_name' => ['string', 'max:255'],
            'guardian_birth_date' => ['date'],
            'guardian_place' => ['string', 'max:255'],
            'guardian_last_education' => ['string', 'max:255'],
            'guardian_job' => ['string', 'max:255'],
            'guardian_email' => ['string', 'max:255'],
            'guardian_phone' => ['string', 'max:255'],
            'affiliate_id' => ['integer'],

            // 'wave_id' => ['integer', 'required'],
            // 'option' => ['integer', 'required'],
            // 'option_2' => ['integer', 'nullable'],


        ];
    }
}
