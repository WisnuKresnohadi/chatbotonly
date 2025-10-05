<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisUserRequest extends FormRequest
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
        $validate = ['roleregister' => 'required|in:user,mitra'];

        if ($this->roleregister == 'user') {
            $validate['nim'] = 'required|numeric|exists:mahasiswa,nim';
        } else if ($this->roleregister == 'mitra') {
            $validate['namaindustri'] = 'required';
            $validate['name'] = 'required';
            $validate['email'] = 'required';
            $validate['notelpon'] = 'required';
        }

        return $validate;
    }
    public function messages()
    {
        return[
            
        ];
    }
}
