<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\JenisMagang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class LowonganMagangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
                        'proses_seleksi.*.tahap' => ['required'],
                        'proses_seleksi.*.deskripsi' => ['required'],
                        'proses_seleksi.*.tgl_mulai' => ['required', function ($attribute, $value, $fail) {
                            $getKey = (int) explode('.', $attribute)[1];
                            $now = Carbon::parse(now()->format('Y-m-d'));
                            $startdate = Carbon::parse($value);
                            if ($getKey > 0) {
                                $previous = $this->proses_seleksi[($getKey - 1)]['tgl_mulai'];

                                if ($startdate->lt($previous)) {
                                    $fail('Tanggal ini tidak boleh lebih awal dari Tanggal Mulai Pelaksanaan sebelumnya.');
                                }
                            }
                            if ($now->gt($startdate)) {
                                $fail('Tanggal ini tidak boleh kurang dari Tanggal Sekarang.');
                            }
                        }],
                        'proses_seleksi.*.tgl_akhir' => ['required', function ($attribute, $value, $fail) {
                            $getKey = (int) explode('.', $attribute)[1];
                            if ($getKey > 0) {
                                $previous = $this->proses_seleksi[($getKey - 1)]['tgl_mulai'];
                                $startdate = Carbon::parse($this->proses_seleksi[($getKey)]['tgl_mulai']);
                                $enddate = Carbon::parse($value);

                                if ($enddate->lt($previous)) {
                                    $fail('Tanggal ini tidak boleh lebih awal dari Tanggal Mulai Pelaksanaan sebelumnya.');
                                }

                                if ($startdate->gt($enddate)) {
                                    $fail('Tanggal ini tidak boleh lebih awal dari Tanggal Mulai Pelaksanaan pada tahap ini.');
                                }
                            }
                        }],
                    ];
                    $validate = array_merge($validate, $addValidate);
                case 2:
                    $addValidate = [
                        // 'requirements' => ['required'],
                        'gender' => ['required', 'array', function ($attribute, $value, $fail) {
                            $validGender = ['Laki-Laki', 'Perempuan', 'Laki-Laki & Perempuan'];
                            $gender = count($this->input('gender')) > 1 ? 'Laki-Laki & Perempuan' : $this->input('gender')[0];

                            if (!in_array($gender, haystack: $validGender)) {
                                $fail('Jenis Kelamin tidak valid');
                            }
                        }],
                        'jenjang' => ['required', 'array', 'min:1', 'in:D3,D4,S1'],
                        'keterampilan' => ['required', 'array', 'min:1'],
                        'persyaratan_tambahan.*.persyaratan_tambah' => [''],
                        'softskill'=>['required','array','max:3'],
                        'softskill.*.string'=>['string'],
                        'pelaksanaan' => ['required', 'in:Online,Onsite,Hybrid'],
                        'gaji' => ['required', 'in:1,0'],
                        'nominal_salary' => ['required_if:gaji,1', function ($attribute, $value, $fail) {
                            if ($this->gaji == 1) {
                                $nominal_salary = str_replace('.', '', $value);
                                $nominal_salary = str_replace(',', '.', $nominal_salary);

                                if (!is_numeric($nominal_salary) || (int) $nominal_salary < 1) {
                                    $fail('Nominal uang saku tidak valid.');
                                }
                            }
                        }],
                        'benefitmagang' => ['nullable', 'string'],
                        'lokasi' => ['required', 'array', 'min:1', 'exists:reg_regencies,name'],
                        // 'tahapan_seleksi' => ['required', 'in:0,1,2'],
                        'tgl_mulai' => ['required'],
                        'tgl_akhir' => ['required', function ($attribute, $value, $fail) {
                            if (isset($value) && isset($this->tgl_mulai)) {
                                $tgl_mulai = Carbon::parse($this->tgl_mulai);
                                $tgl_akhir = Carbon::parse($value);
                                if ($tgl_mulai->gt($tgl_akhir)) {
                                    $fail('Tanggal ini tidak boleh kurang dari Tanggal Mulai Pelaksaan.');
                                }
                            }
                        }],
                    ];
                    $validate = array_merge($validate, $addValidate);
                case 1:
                    $addValidate = [
                        'id_jenismagang' => ['required', 'exists:jenis_magang,id_jenismagang'],
                        'intern_position' => ['required'],
                        'kuota' => ['required', 'integer', 'min:1'],
                        'deskripsi' => ['required'],
                        'durasimagang' => ['required', 'array', 'min:1', 'in:1 Semester,2 Semester'],
                        'startdate' => ['required'],
                        'enddate' => ['required', function ($attribute, $value, $fail) {
                            if (isset($value) && isset($this->startdate)) {
                                $startdate = Carbon::parse($this->startdate);
                                $enddate = Carbon::parse($value);
                                $now = Carbon::parse(now()->format('Y-m-d'));

                                if ($startdate->gt($enddate)) {
                                    $fail('Tanggal ini tidak boleh lebih kecil dari Tanggal Lowongan Ditayangkan');
                                }
                                if ($now->gt($enddate)) {
                                    $fail('Tanggal ini tidak boleh kurang dari Tanggal Sekarang.');
                                }
                            }
                        }],
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
            // step 1
            'id_jenismagang.required' => 'Pilih Jenis Magang terlebih dahulu.',
            // 'id_jenismagang.exists' => 'Jenis Magang tidak valid.',
            'intern_position.required' => 'Posisi Magang wajib diisi',
            'kuota.required' => 'Kuota wajib di isi',
            'kuota.integer' => 'Kuota harus berupa angka',
            'kuota.min' => 'Kuota minimal 1',
            'deskripsi.required' => 'Deskripsi wajib di isi',
            'deskripsi.string' => 'Format deskripsi tidak valid',
            // step 2
            'requirements.required' => 'Kualifikasi Magang wajib diisi',
            'gender.required' => 'Jenis Kelamin wajib dipilih',
            'gender.in' => 'Jenis Kelamin tidak valid',
            'jenjang.required' => 'Jenjang wajib dipilih',
            'jenjang.min' => 'Jenjang wajib dipilih',
            'jenjang.in' => 'Jenjang tidak valid',
            'keterampilan.required' => 'Keterampilan wajib diisi',
            'keterampilan.min' => 'Keterampilan wajib diisi',
            'pelaksanaan.required' => 'Pelaksanaan Magang wajib dipilih',
            'pelaksanaan.in' => 'Pelaksanaan Magang tidak valid',
            'gaji.required' => 'Gaji wajib dipilih',
            'gaji.in' => 'Gaji tidak valid',
            'nominal_salary.required_if' => 'Nominal Gaji wajib diisi',
            'benefitmagang.string' => 'Format benefit tidak valid',
            'lokasi.required' => 'Lokasi Magang wajib diisi',
            'lokasi.min' => 'Lokasi Magang wajib diisi',
            'softskill.required' => 'Softskill wajib diisi',
            'softskill.max' => '*Maksimal 3 Jenis Soft Skill yang dapat dipilih',
            'startdate.required' => 'Waktu Mulai Magang wajib diisi',
            'enddate.required' => 'Waktu Akhir Magang wajib diisi',
            'durasimagang.required' => 'Durasi Magang wajib dipilih',
            'durasimagang.min' => 'Durasi Magang wajib dipilih',
            'durasimagang.in' => 'Durasi Magang tidak valid',
            'tahapan_seleksi.required' => 'Tahapan Magang wajib dipilih',
            'tahapan_seleksi.in' => 'Tahapan Magang tidak valid',
            // step 3
            'proses_seleksi.*.deskripsi.required' => 'Deskripsi Seleksi harus diisi.',
            'tgl_mulai.required' => 'Pilih tanggal mulai pelaksanaan.',
            'tgl_akhir.required' => 'Pilih tanggal akhir pelaksanaan.',
            // 'proses_seleksi.*.tgl_mulai.required' => 'Pilih tanggal mulai pelaksanaan.',
            // 'proses_seleksi.*.tgl_akhir.required' => 'Pilih tanggal akhir pelaksanaan.',

        ];
    }
}
