<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdiRequest extends FormRequest
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
            'id_univ' => ['required', 'exists:universitas,id_univ'],
            'id_fakultas' => ['required', 'exists:fakultas,id_fakultas'],
            'namaprodi' => ['required', 'string', 'max:255'],
            'jenjang' => ['required', 'in:D3,D4,S1,S2'],
        ];
    }

    public function messages()
    {
        return [
            'id_univ.required' => 'Pilih Universitas!',
            'id_fakultas.required' => 'Pilih Fakultas!',
            'namaprodi.required' => 'Masukkan Nama Prodi!',
            'jenjang.required' => 'Pilih Jenjang!',
            'jenjang.in' => 'Jenjang tidak valid!'
        ];
    }
}