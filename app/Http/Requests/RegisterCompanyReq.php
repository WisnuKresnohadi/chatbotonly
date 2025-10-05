<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCompanyReq extends FormRequest
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
            'name' => 'required|min:3|max:100',
            'email' => 'required|email:rfc,dns|unique:users',
            'namaindustri' => 'required|min:5|max:255',
            'notelpon' => 'required|numeric|min:6'
         ];
     }



    public function messages()
    {
        return [
            'name.required' => 'nama wajib di isi ',
            'name.max' => 'max 100 karakter',
            'name.min' => 'min 3 karakter',

            'email.required' => 'email wajib di isi ',
            'email.unique' => 'email sudah terdaftar',
            'email.email' => 'format salah',
            'email.rfc,dns' => 'masukkan email dengan benar',

            'namaindustri.required' => 'nama perusahaan wajib di isi ',
            'namaindustri.min' => 'Minimal 5 karakter',
            'namaindustri.max' => 'Maksimal 255 karakter',

            'notelpon.required' => 'no telepon wajib di isi',
            'notelpon.numeric' => 'no telepon berupa angka',
            'notelpon.min' => 'no telepon min 6', 
        ];
    }
}
