<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FakultasRequest extends FormRequest
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
            'namauniv' => ['required', 'exists:universitas,id_univ'],
            'namafakultas' => ['required'],
        ];

        return $validate;
    }           
    public function messages(): array
    {
        return [
            
            'namauniv.required' => 'Pilih Universitas',
            'namauniv.exists' => 'Universitas tidak ditemukan',
            'namafakultas.required' => 'Nama fakultas tidak boleh kosong',
        ];
    }
}