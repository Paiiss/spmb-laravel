<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'bank' => ['string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'numeric', 'min:0'],
            'amount' => ['required', 'numeric', 'min:0',],
            'date' => ['required', 'date'],
            'image' => ['required', 'image', 'extensions:jpeg,png,jpg,gif,svg', 'max:5000'],
            'type_payment' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
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
            'image.required' => 'Gambar tidak boleh kosong',
            'image.image' => 'File harus berupa gambar',
            'image.extensions' => 'File harus berupa gambar dengan format jpeg, png, jpg, gif, svg',
            'image.max' => 'Ukuran file tidak boleh lebih dari 5 MB',
            'required' => 'Kolom :attribute tidak boleh kosong',
            'string' => 'Kolom :attribute harus berupa string',
            'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter',
            'numeric' => 'Kolom :attribute harus berupa angka',
            'min' => 'Kolom :attribute tidak boleh kurang dari :min',
            'date' => 'Kolom :attribute harus berupa tanggal',
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
            'bank' => 'Bank',
            'account_name' => 'Nama Akun',
            'account_number' => 'Nomor Akun',
            'amount' => 'Jumlah',
            'date' => 'Tanggal',
            'image' => 'Gambar',
            'type_payment' => 'Tipe Pembayaran',
            'code' => 'Kode',
        ];
    }
}
