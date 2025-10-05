<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BidangPekerjaanRequest extends FormRequest
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
                'name' => ['required', 'string', Rule::unique('bidang_pekerjaan')->ignore($this->id, 'id_bidang_pekerjaan')]    
            ];
        }
       

        return [
            'name' => ['required', 'string', 'unique:bidang_pekerjaan,name']  
        ];
    }

    public function messages(): array
    {
        return [            
            'name.required' => 'Nama bidang pekerjaan tidak boleh kosong',           
            'name.unique' => 'Nama bidang pekerjaan sudah ada',           
        ];
    }
}
