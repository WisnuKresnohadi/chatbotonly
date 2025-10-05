<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformasiTambahanReq extends FormRequest
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
        return [
            'lokasi_yg_diharapkan' => 'required|max:255|string',
            'bahasa' => 'required|array|min:1',
            'sosmedmhs_.*.namaSosmed' => 'required|max:255|in:Instagram,Linkedin,Facebook,Twitter',
            'sosmedmhs_.*.urlSosmed' => 'required',
            'sosmedmhs_' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return[
            'lokasi_yg_diharapkan.required' => 'Lokasi Magang wajib di isi',
            'lokasi_yg_diharapkan.string' => 'lokasi magang berupa huruf',
            'lokasi_yg_diharapkan.max' => 'lokasi magang maksimal 255 karakter',
            'bahasa.required' => 'Bahasa Wajib di isi.',
            'bahasa.array' => 'Bahasa Wajib di isi.',
            'bahasa.min' => 'Bahasa Wajib di isi.',
            'sosmedmhs_.*.namaSosmed.required' => 'Pilih Sosmed',
            'sosmedmhs_.*.namaSosmed.in' => 'Pilihan sosmed tidak valid',
            'sosmedmhs_.*.urlSosmed.required'=> 'url wajib di isi',
            'sosmedmhs_.*.urlSosmed.url'=> 'url tidak valid',
            'sosmedmhs_.required' => 'Sosmed tidak boleh kosong',
        ];
    }
}
