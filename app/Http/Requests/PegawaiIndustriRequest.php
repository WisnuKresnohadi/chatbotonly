<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PegawaiIndustriRequest extends FormRequest
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
            'namapeg' => ['required', 'string', 'max:255'],
            'nohppeg' => ['required', 'phone:id'],
            'emailpeg' => ['required', 'email', 'unique:pegawai_industri,emailpeg', 'unique:users,email'],
            'jabatan' => ['required_if:jabatan,!=,Administrator', 'string', 'max:255'],
        ];

        if (isset($this->id)){
            $validate['emailpeg'] = ['required', 'email', Rule::unique('pegawai_industri')->ignore($this->id, 'id_peg_industri')];
        }

        return $validate;
    }

    public function messages()
    {
        return[
            'namapeg.required' => 'Nama Pegawai harus diisi.',
            'nohppeg.required' => 'No HP harus diisi.',
            'nohppeg.phone' => 'No HP tidak valid.',
            'emailpeg.required' => 'Email harus diisi.',
            'emailpeg.email' => 'Email tidak valid.',
            'emailpeg.unique' => 'Email sudah terdaftar.',
            'jabatan.required' => 'Jabatan harus diisi.',
        ];
    }
}
