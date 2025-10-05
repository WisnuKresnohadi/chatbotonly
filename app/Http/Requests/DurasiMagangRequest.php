<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DurasiMagangRequest extends FormRequest
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
                'name' => ['required', 'string', Rule::unique('durasi_magang')->ignore($this->id, 'id_durasi_magang')]    
            ];
        }
       

        return [
            'name' => ['required', 'string', 'unique:durasi_magang,name']  
        ];
    }

    public function messages(): array
    {
        return [            
            'name.required' => 'Nama durasi magang tidak boleh kosong',           
            'name.unique' => 'Nama durasi magang sudah ada',           
        ];
    }
}
