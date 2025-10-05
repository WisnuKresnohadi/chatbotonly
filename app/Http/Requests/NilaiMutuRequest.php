<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NilaiMutuRequest extends FormRequest
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
            'nilaimin' => ['required', 'numeric', 'between:0,90'],
            'nilaimax' => ['required', 'numeric', 'between:0,100'],
            'nilaimutu' => ['required', 'alpha', 'max:2'],
            'bobot' => ['required', 'numeric', 'between:0,4'],
        ];
    }

    public function messages()
    {
        return [
            'nilaimin.required' => 'The minimum value must be filled',
            'nilaimax.required' => 'The maximum value must be filled',
            'nilaimutu.required' => 'The quality value must be filled',
            'bobot.required' => 'The bobot value must be filled',
            'nilaimin.numeric' => 'The minimum value must be number',
            'nilaimax.numeric' => 'The maximum value must be number',
            'bobot.numeric' => 'The maximum value must be number',
            'nilaimin.between' => 'The minimum value must be between 0 and 90',
            'nilaimax.between' => 'The maximum value must be between 0 and 100',
            'bobot.between' => 'The maximum value must be between 0 and 4'
        ];
    }
}
