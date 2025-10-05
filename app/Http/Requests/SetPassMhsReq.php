<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetPassMhsReq extends FormRequest
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
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ]
        ];
    }

    public function messages()
    {
        return[
            'password.required' => 'Password diperlukan.',
            'password.string' => 'Password harus berupa string.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'password.regex' => 'Password harus memiliki campuran huruf besar dan kecil, angka, dan simbol.'
        ];
    }
}
