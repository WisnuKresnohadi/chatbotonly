<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformasiPengalamanReq extends FormRequest
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
            'kategori' => 'required|in:project,competition,profesional',
        
            // Aturan umum yang berlaku untuk semua pengalaman
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
            'deskripsi' => 'required|string|max:255',
        
            // Aturan khusus berdasarkan kategori
            'nama' => 'required_if:kategori,project,competition|string|max:255',
            'posisi' => 'required_if:kategori,project,profesional|string|max:255',
            'jenis' => 'required_if:kategori,profesional|string|max:255',
            'prestasi' => 'required_if:kategori,competition|string|max:255',
            'name_intitutions' => 'required_if:kategori,profesional|string|max:255',
        ];
        
        if ($this->data_id) {
            $validate['data_id'] = 'required|exists:experience,id_experience';
        }

        return $validate;
    }

    public function messages()
    {
        return[
            'posisi.required' => 'Posisi Wajib Di isi',            
            'jenis.required_with_all' => 'jenis pekerjaan wajib di isi',
            'name_intitutions.required_with' => 'nama perusahaan wajib di isi',
            'startdate.required' => 'tanggal mulai tidak boleh kosong',
            'enddate.required' => 'tanggal berakhir tidak boleh kosong',
            'deskripsi.required' => 'deskripsi pekerjaan wajib di isi'
        ];
    }
}
