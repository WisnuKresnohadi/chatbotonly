<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Industri;
use App\Models\PegawaiIndustri;
use Illuminate\Foundation\Http\FormRequest;

class CompanyReg extends FormRequest
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
            'namaindustri' => 'required|string|min:5|max:255',
            'email' => 'required|email|unique:users,email|unique:pegawai_industri,emailpeg',
            'contact_person' => 'required',
            'penanggung_jawab' => 'required',
            'alamat' => 'required',
            'deskripsi' => 'required',
            'kategori_industri' => 'required|in:Internal,Eksternal',
            'statuskerjasama' => 'required|in:Iya,Tidak',
        ];

        if ($this->id) {
            $validate['email'] = ['required', 'email', function ($attribute, $value, $fail) {
                $industri = Industri::where('id_industri', $this->id)->first();
                if (!$industri) $fail('Not Found.');
                
                $pegawaiIndustri = PegawaiIndustri::where('id_peg_industri', '!=', $industri->penanggung_jawab)->where('emailpeg', $value)->count();
                if ($pegawaiIndustri > 0) $fail('Email sudah terdaftar');

                $pegawaiIndustri = PegawaiIndustri::where('id_peg_industri', $industri->penanggung_jawab)->first();
                $user = User::where('id', '!=', $pegawaiIndustri->id_user)->where('email', $value)->count();
                if ($user > 0) $fail('Email sudah terdaftar');
            }];
        }

        return $validate;
    }
    public function messages()
    {
        return [

            'email.required' => 'Email wajib di isi',
            'email.unique' => 'Email sudah terdaftar',
            'email.email' => 'Format email tidak sesuai',
            'namaindustri.required' => 'Nama Perusahaan wajib di isi',
            'namaindustri.min' => 'Minimal 5 karakter',
            'namaindustri.max' => 'Maksimal 60 karakter',
            'kategori_industri.required' => 'Kategori Perusahaan wajib di isi',
            'kategori_industri.in' => 'Kategori Perusahaan tidak sesuai',
            'statuskerjasama.required' => 'Status Perusahaan wajib di isi',
            'statuskerjasama.in' => 'Status Perusahaan tidak sesuai',
            'contact_person.required' => 'Contact Person wajib di isi',
            'penanggung_jawab.required' => 'Penanggung jawab wajib di isi',
            'alamat.required' => 'Alamat Perusahaan wajib di isi',
            'deskripsi.required' => 'Deskripsi Perusahaan wajib di isi',
        ];
    }
}
