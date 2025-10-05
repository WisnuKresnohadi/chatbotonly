<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KonfirmasiMagangRequest extends FormRequest
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
            'mulai' => ['required'],
            'akhir' => ['required'],
            'bukti_doc' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'mulai' => 'Kolom Tanggal Mulai harus diisi!',
            'akhir' => 'Kolom Tanggal Akhir harus diisi!',
            'bukti_doc' => 'Kolom Bukti Penerimaan Magang harus diisi!'
        ];
    }
}
