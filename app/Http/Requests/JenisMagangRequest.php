<?php

namespace App\Http\Requests;

use App\Models\JenisMagang;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class JenisMagangRequest extends FormRequest
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
            'data_step' => ['required']
        ];

        if (isset($this->data_step)) {
            $dataStep = Crypt::decryptString($this->data_step);
            switch ($dataStep) {
                case 3:
                    $addValidate = [
                        'berkas.*.namaberkas' => ['required'],
                        'berkas.*.statusupload' => ['required', 'in:1,0'],
                        'berkas.*.template' => ['nullable', 'mimes:pdf,doc,docx', 'max:2048'],
                        'berkas.*.due_date' => ['required'],
                    ];
                    $validate = array_merge($validate, $addValidate);
                case 2:
                    $addValidate = ['dokumen_persyaratan.*.namadocument' => ['required']];
                    $validate = array_merge($validate, $addValidate);
                case 1:
                    $addValidate = [
                        'namajenis' => ['required', function ( $attribute, $value, $fail) {
                            $jenisMagang = JenisMagang::select(DB::raw(1))
                                ->where('namajenis', $value)
                                ->where('durasimagang', $this->durasimagang)
                                ->where('id_year_akademik', $this->id_year_akademik)
                                ->where('id_jenismagang', '!=', $this->id)
                                ->first();
                            if ($jenisMagang) $fail('Jenis Magang sudah ada!');
                        }],
                        'durasimagang' => ['required', 'in:1 Semester,2 Semester'],
                        'id_year_akademik' => ['required', 'exists:tahun_akademik,id_year_akademik'],
                        'desc' => ['required'],
                    ];
                    $validate = array_merge($validate, $addValidate);
                default:
                    break;
            }
        }

        // if (isset($this->id)) {
        //     $validate['berkas.*.template'] = ['nullable', 'mimes:pdf', 'max:2048'];
        // }

        return $validate;
    }

    public function messages(): array
    {
        return [
            'data_step.required' => 'Tidak valid!',
            'namajenis.required' => 'Jenis Magang harus diisi!',
            'durasimagang.required' => 'Durasi Magang harus dipilih!',
            'durasimagang.in' => 'Durasi Magang tidak valid!',
            'id_year_akademik.required' => 'Tahun Akademik harus dipilih!',
            'id_year_akademik.exists' => 'Tahun Akademik tidak valid!',
            'desc.required' => 'Deskripsi harus diisi!',
            'dokumen_persyaratan.*.namadocument.required' => 'Dokumen Persyaratan harus diisi!',
            'berkas.*.namaberkas.required' => 'Berkas Magang harus diisi!',
            'berkas.*.statusupload.required' => 'Status Upload harus dipilih!',
            'berkas.*.statusupload.in' => 'Status Upload tidak valid!',
            'berkas.*.template.required' => 'Template harus diisi!',
            'berkas.*.template.mimes' => 'Template harus berupa PDF, DOC, atau DOCX!',
            'berkas.*.template.max' => 'File Template tidak boleh lebih dari 2 MB!',
            'berkas.*.due_date.required' => 'Due Date harus diisi!',
        ];
    }
}
