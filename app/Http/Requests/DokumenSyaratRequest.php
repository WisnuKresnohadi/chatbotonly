<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokumenSyaratRequest extends FormRequest
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
            'namajenis' => ['required'],
            'namadoc' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'namajenis.required' => 'Type of internship must be filled',
            'namadoc.required' => 'Document name must be filled'
        ];
    }
}
