<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformasiKeahlianReq extends FormRequest
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
            'skills' => 'required|array|min:1',
        ];
    }
    public function messages()
    {
        return [
            'skills.required' => 'Keahlian wajib di isi',
            'skills.min' => 'Keahlian wajib di isi',
            'skills.array' => 'Keahlian wajib di isi',
        ];
    }
}
