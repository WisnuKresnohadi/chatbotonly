<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Dosen;
use App\Models\Universitas;
use App\Models\ProgramStudi;

class DosenRequest extends FormRequest
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
            'nip' => ['required', 'integer', 'unique:dosen,nip'],
            'id_univ' => ['required', 'string', 'exists:universitas,id_univ'],
            'id_fakultas' => ['required', 'string', 'exists:fakultas,id_fakultas'],
            'id_prodi' => ['required', 'string', 'exists:program_studi,id_prodi'],
            'kode_dosen' => ['required', 'string', 'max:5', 'unique:dosen,kode_dosen'],
            'namadosen' => ['required', 'string'],
            'nohpdosen' => ['required', 'string', 'max:255', 'phone:id'],
            'emaildosen' => ['required', 'string', 'max:255', 'email', 'unique:dosen,emaildosen', 'unique:users,email'],
        ];

        if (isset($this->id)) {
            $validate['nip'] = ['required', 'integer', Rule::unique('dosen')->ignore($this->id, 'nip')];
            $validate['kode_dosen'] = ['required', 'integer', Rule::unique('dosen')->ignore($this->id, 'kode_dosen')];
            $validate['emaildosen'] = ['required', 'integer', Rule::unique('dosen')->ignore($this->id, 'emaildosen'), Rule::unique('users')->ignore($this->id, 'email')];
        }

        return $validate;
    }
    public function messages(): array
    {
        return [
            'nip.unique' => 'NIP sudah terdaftar',
            'nip.required' => 'NIP harus diisi',
            'nip.integer' => 'NIP harus berupa angka',
            'id_univ.required' => 'Pilih universitas',
            'id_univ.exists' => 'Universitas tidak ditemukan',
            'id_fakultas.required' => 'Pilih fakultas',
            'id_fakultas.exists' => 'Fakultas tidak ditemukan',
            'id_prodi.required' => 'Pilih prodi',
            'id_prodi.exists' => 'Prodi tidak ditemukan',
            'kode_dosen.required' => 'Kode Dosen harus diisi',
            'kode_dosen.unique' => 'Kode Dosen sudah terdaftar',
            'kode_dosen.max' => 'Kode Dosen maksimal 5 karakter',
            'namadosen.required' => 'Namael harus diisi',
            'nohpdosen.required' => 'No HP harus diisi',
            'emaildosen.required' => 'Email harus diisi',
            'emaildosen.email' => 'Email harus valid',
            'emaildosen.unique' => 'Email sudah terdaftar',
            'nohpdosen.phone' => 'No HP tidak valid',
            'nohpdosen.max' => 'No HP tidak valid',
            'emaildosen.max' => 'Email tidak valid',
        ];
    }
}
