<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformasiPendidikanReq extends FormRequest
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
            'name_intitutions' => 'required|max:100',
            'tingkat' => 'required|in:SMP,SMA,SMK,D3,D4,S1',
            'startdate' => 'required',
            'enddate' => 'required',
            'nilai' => 'required|numeric|min:0|max:100'
        ];

        if ($this->data_id) {
            $validate['data_id'] = 'required|exists:education,id_education';
        }


        return $validate;
    }

    public function messages()
    {
        return[
            'id_education.required' => 'Invalid.',
            'name_intitutions.required' => 'nama institusi wajib di isi',
            'tingkat.required' => 'tingkat wajib di isi',
            'startdate.required' => 'Tahun Pelaksanaan wajib di isi',
            'enddate.required' => 'Tahun kelulusan wajib di isi',
            'nilai.required' => 'nilai wajib di isi',
            'nilai.numberic' => 'nilai berupa angka',
            'nilai.min' => 'nilai tidak boleh minus',
            'nilai.max' => 'nilai tidak lebih dari 100'
        ];
    }
}
