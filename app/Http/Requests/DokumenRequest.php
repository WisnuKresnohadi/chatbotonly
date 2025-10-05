<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DokumenRequest extends FormRequest
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
            'nama_sertif' => 'required|max:255|min:3',
            'penerbit' => 'required|max:255|min:3',
            'file_sertif' =>  'required|file|max:2000|mimes:doc,docx,pdf,png,jpeg,jpg',
            'link_sertif' => 'nullable|url|max:255',
            'startdate' => 'required',
            'enddate' => 'nullable',
            'deskripsi' => 'nullable|max:255|string'
        ];

        if ($this->data_id) $validate['file_sertif'] = 'nullable|file|max:2000|mimes:doc,docx,pdf,png,jpeg,jpg';

        return $validate;
    }

    public function messages()
    {
        return [
            'nama_sertif.required' => 'Masukkan Nama Dokumen',
            'penerbit.required' => 'Masukkan Penerbit',
            'penerbit.min' => 'Masukkan Penerbit Minimal 3 Karakter',
            'file_sertif.required' => 'Masukkan File Dokumen',
            'link_sertif.required' => 'Masukkan Link Dokumen',
            'startdate.required' => 'Masukkan Start Date',
            'enddate.required' => 'Masukkan End Date',
            'deskripsi.required' => 'Masukkan Deskripsi',
            'file_sertif.max' => 'File tidak boleh lebih dari 2000 KB',
            'file_sertif.mimes' => 'File harus berupa doc, docx, pdf, png, jpeg, jpg',
            'link_sertif.url' => 'Masukkan link dengan benar',
            'link_sertif.max' => 'Link tidak boleh lebih dari 255 karakter',
        ];
    }
}
