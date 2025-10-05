<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class NilaiPembAkademikReq extends FormRequest
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
        $validate = ['data_step' => 'required'];

        if (isset($this->data_step)) {
            $dataStep = Crypt::decryptString($this->data_step);
            switch ($dataStep) {
                case 2:
                case 1:
                    $addValidate = [
                        'id_kompnilai' => 'required|array',
                        'id_kompnilai.*' => 'required',
                        'nilai' => 'required|array',
                        'nilai.*' => 'required|integer'
                    ];
                    $validate = array_merge($validate, $addValidate);
                default:
                    break;
            }
        }

        return $validate;
    }

    public function messages(): array
    {
        return [
            'id_kompnilai.required' => 'Invalid',
            'id_kompnilai.array' => 'Invalid',
            'id_kompnilai.*.required' => 'Invalid',
            'nilai.required' => 'Nilai harus diisi',
            'nilai.array' => 'Nilai harus diisi',
            'nilai.*.required' => 'Nilai harus diisi',
        ];
    }
}
