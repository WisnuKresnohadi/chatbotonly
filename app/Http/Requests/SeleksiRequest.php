<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeleksiRequest extends FormRequest
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
        if (isset($this->id)) {
            return [
                'tahapan_seleksi' => ['required', Rule::unique('seleksi_lowongan')->ignore($this->id, 'id_seleksi_lowongan')],
                'mulai' => ['required'],
                'subjek' => ['required'],
            ];
        }
        return [
            'tahapan_seleksi' => ['required', 'unique:seleksi_lowongan'],
            'mulai' => ['required'],
            'subjek' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'tahapan_seleksi.required' => 'Tahap harus diisi!',
            'tahapan_seleksi.unique' => 'Tahap tersebut sudah ada!',
            'mulai.required' => 'Date harus diisi!',
            'subjek.required' => 'Email subject harus diisi!'
        ];
    }
}
