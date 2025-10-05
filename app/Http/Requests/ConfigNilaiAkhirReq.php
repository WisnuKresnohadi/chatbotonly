<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PDO;

class ConfigNilaiAkhirReq extends FormRequest
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
            'id_prodi' => ['required', 'exists:program_studi,id_prodi', 'unique:config_nilai_akhir,id_prodi'],
            'nilai_pemb_lap' => ['required', 'min:1', 'max:100', function ( $attribute, $value, $fail) {
                if (($value + $this->nilai_pemb_akademik) > 100) $fail('Nilai pembimbing lapangan + pembimbing akademik tidak boleh melebihi 100');
            }],
            'nilai_pemb_akademik' => ['required', 'min:1', 'max:100', function ( $attribute, $value, $fail) {
                if (($value + $this->nilai_pemb_lap) > 100) $fail('Nilai pembimbing lapangan + pembimbing akademik tidak boleh melebihi 100');
            }]
        ];

        if ($this->id) {
            $validate['id_prodi'] = ['required', 'exists:program_studi,id_prodi', 'unique:config_nilai_akhir,id_prodi,' . $this->id . ',id_config_nilai_akhir'];
        }

        return $validate;
    }

    public function messages(): array
    {
        return [
            'id_prodi.unique' => 'Program studi sudah ada.',
            'id_prodi.exists' => 'Program studi tidak ditemukan.',
            'id_prodi.required' => 'Program studi harus diisi.',
            'nilai_pemb_lap.required' => 'Nilai pembimbing lapangan harus diisi.',
            'nilai_pemb_lap.min' => 'Nilai pembimbing lapangan minimal 1.',
            'nilai_pemb_lap.max' => 'Nilai pembimbing lapangan tidak boleh melebihi 100.',
            'nilai_pemb_akademik.required' => 'Nilai pembimbing akademik harus diisi.',
            'nilai_pemb_akademik.min' => 'Nilai pembimbing akademik minimal 1.',
            'nilai_pemb_akademik.max' => 'Nilai pembimbing akademik tidak boleh melebihi 100.',
        ];
    }
}
