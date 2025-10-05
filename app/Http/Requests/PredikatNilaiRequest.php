<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PredikatNilaiRequest extends FormRequest
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
                'nama' => ['required', 'string', Rule::unique('predikat_nilai')->ignore( $this->id,'id_predikat_nilai')],   
                'nilai' => ['required', 'integer', 'between:1,100']    
            ];
        }
       

        return [
            'nama' => ['required', 'string', 'unique:predikat_nilai,nama']  
        ];
    }

    public function messages(): array
    {
        return [            
            'nama.required' => 'Nama Predikat Nilai tidak boleh kosong',           
            'nama.unique' => 'Nama Predikat Nilai sudah ada',                       
            'nilai.require' => 'Nilai tidak boleh kosong',           
            'nilai.between' => 'Nilai harus di antara 1 hingga 100',           
        ];
    }
}
