<?php

namespace App\Http\Requests;

use App\Models\PegawaiIndustri;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BidangPekerjaanIndustriRequest extends FormRequest
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
        $idIndustri = PegawaiIndustri::where('id_user', auth()->user()->id)->pluck('id_industri')->first();

        if (isset($this->id)) {
            return [
                'namabidangpekerjaan' => [
                    'required',
                    'string',
                    Rule::unique('bidang_pekerjaan_industri')
                        ->ignore($this->id, 'id_bidang_pekerjaan_industri')
                        ->where('id_industri', $idIndustri)
                ]
            ];
        }

        return [
            'namabidangpekerjaan' => [
                'required',
                'string',
                Rule::unique('bidang_pekerjaan_industri')
                    ->where('id_industri', $idIndustri)
            ],
            'deskripsi' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'namabidangpekerjaan.required' => 'Nama bidang pekerjaan tidak boleh kosong',
            'namabidangpekerjaan.unique' => 'Nama bidang pekerjaan sudah ada',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong'
        ];
    }
}
