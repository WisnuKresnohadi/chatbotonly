<?php

namespace App\Http\Requests;

use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\Mahasiswa;
use App\Models\Universitas;
use App\Models\ProgramStudi;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class MahasiswaRequest extends FormRequest
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
        $nim = ['required', 'string','max:15','unique:mahasiswa,nim'];
        $email = ['required', 'string', 'max:255', 'unique:mahasiswa,emailmhs', 'unique:users,email'];

        if (isset($this->id)) {
            $nim = ['required', 'string', 'max:15', Rule::unique('mahasiswa', 'nim')->ignore($this->id, 'nim')];
            $mahasiswa = Mahasiswa::where('nim', $this->id)->first();
            $email = ['required', 'string', 'max:255', Rule::unique('mahasiswa', 'emailmhs')->ignore($this->id, 'nim'), Rule::unique('users', 'email')->ignore($mahasiswa?->id_user, 'id')];
        }  
        return [
            'nim' => $nim,
            'angkatan' => ['required', 'integer'],
            'id_prodi' => ['required', 'string','max:255', function ($attribute, $value, $fail) {
                $fakultas = Fakultas::where('id_fakultas', $this->id_fakultas)->first();
                $prodi = $fakultas->program_studi()?->where('id_prodi', $value)->first();
                if (!$prodi) {
                    $fail('Program Studi not found');
                }
            }],
            'id_univ' => ['required', 'string', 'max:255', 'exists:universitas,id_univ'],
            'id_fakultas' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) {
                $univ = Universitas::where('id_univ', $this->id_univ)->first();
                $fakultas = $univ->fakultas()?->where('id_fakultas', $value)->first();
                if (!$fakultas) {
                    $fail('Fakultas not found');
                }
            }],
            'kode_dosen_wali' => ['required', 'string', 'max:5', function ($attribute, $value, $fail) {
                $dosen = Dosen::where('kode_dosen', $value)->first();
                if (!$dosen) $fail('Dosen not found');
            }],
            'namamhs' => ['required', 'string', 'max:255'],
            'alamatmhs' => ['required', 'string', 'max:255'],
            'emailmhs' => $email,
            'nohpmhs' => ['required'],
            'eprt' => ['required', 'numeric',],
            'tak' => ['required', 'numeric',],
            'ipk' => ['required', 'regex:/^\d{1}(\.\d{0,2})?$/',],
            'tunggakan_bpp' => ['required', 'string', 'in:Iya,Tidak'],
        ];
    }           
    public function messages(): array
    {
        return [
            'nim.required' => 'NIM must be filled',
            'nim.unique' => 'NIM already exist',
            'angkatan.required' => 'Angkatan must be filled',
            'id_prodi.required' => 'Prodi must be filled',
            'id_prodi.exists' => 'Prodi not found',
            'id_univ.required' => 'Universitas must be filled',
            'id_univ.exists' => 'Universitas not found',
            'id_fakultas.required' => 'Fakultas must be filled',
            'id_fakultas.exists' => 'Fakultas not found',
            'kode_dosen_wali.required' => 'Dosen must be filled',
            'kode_dosen_wali.exists' => 'Dosen not found',
            'kode_dosen_wali.max' => 'Dosen must be 5 characters',
            'namamhs.required' => 'The name of Mahasiswa must be filled',
            'emailmhs.required' => 'The Email must be filled',
            'emailmhs.unique' => 'The Email already exist',
            'nohpmhs.required' => 'The phone number must be filled',
            'nohpmhs.phone' => 'The phone number must be valid',
            'alamatmhs.required' => 'The address must be filled',
            'eprt.required' => 'The EPRT must be filled',
            'tak.required' => 'The TAK must be filled',
            'ipk.required' => 'The IPK must be filled',
            'tunggakan_bpp.required' => 'Choose tungggakan BPP',
            'tunggakan_bpp.in' => 'Tungggakan BPP invalid',
        ];
    }
}