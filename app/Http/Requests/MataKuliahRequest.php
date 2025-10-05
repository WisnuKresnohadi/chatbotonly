<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MataKuliahRequest extends FormRequest
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
            'kode_mk' => ['required', 'string', 'max:255' ,'unique:mata_kuliah,kode_mk'],                        
            'namamk' => ['required', 'string', 'max:255'],
            'id_univ' => ['required', 'string', 'exists:universitas,id_univ'],
            'id_fakultas' => ['required', 'string', 'exists:fakultas,id_fakultas'],
            'id_prodi' => ['required', 'string', 'exists:program_studi,id_prodi'],
            'sks' => ['required', 'integer', 'between:1,20'],            
        ];

        if (isset($this->id)) {
            $validate['kode_mk'] = ['required', 'string', 'max:255', Rule::unique('mata_kuliah')->ignore($this->id, 'kode_mk')];           
        }  

        return $validate;
    }

    public function messages(): array
    {
        return [
            'kode_mk.unique' => 'Kode Mata Kuliah sudah terdaftar',
            'kode_mk.required' => 'Kode Mata Kuliah harus diisi',
            'kode_mk.string' => 'Kode Mata Kuliah harus berupa string',
            'kode_mk.max' => 'Kode Mata Kuliah tidak boleh lebih dari 255 karakter',
            'id_univ.required' => 'Pilih universitas',
            'id_univ.exists' => 'Universitas tidak ditemukan',
            'id_fakultas.required' => 'Pilih fakultas',
            'id_fakultas.exists' => 'Fakultas tidak ditemukan',
            'id_prodi.required' => 'Pilih prodi',
            'id_prodi.exists' => 'Prodi tidak ditemukan',          
            'namamk.required' => 'Nama Mata Kuliah harus diisi', 
            'namamk.max' => 'Nama Mata Kuliah tidak boleh lebih dari 255 karakter',
            'sks.required' => 'SKS harus diisi',
            'sks.integer' => 'SKS harus berupa angka',
            'sks.between' => 'SKS harus di antara 1 hingga 20',           
        ];
    }
}
