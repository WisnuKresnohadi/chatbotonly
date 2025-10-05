<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UniversitasRequest extends FormRequest
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
        $validate = [
            'namauniv' => ['required', 'string', 'max:255', 'unique:universitas'],
            'jalan' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'telp' => ['phone:id'],
        ];
        if (isset($this->id)) {
            $validate['namauniv'] = ['required', 'string', 'max:255', Rule::unique('universitas')->ignore($this->id, 'id_univ')];
        }

        return $validate;
    }

    public function messages(): array
    {
        return [
            'namauniv.unique' => 'Nama Universitas sudah terdaftar',
            'namauniv.required' => 'Nama Universitas harus diisi',
            'jalan.required' => 'Alamat harus diisi',
            'kota.required' => 'Kota harus diisi',
            'telp.required' => 'Telp harus diisi',
            'telp.phone' => 'Nomor telpon tidak valid',
        ];
    }
}
