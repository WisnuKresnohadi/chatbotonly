<?php

namespace App\Http\Requests;

use App\Models\MataKuliah;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class BidangPekerjaanMkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorize the request
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
            'id_bidang_pekerjaan_industri' => 'required|exists:bidang_pekerjaan_industri,id_bidang_pekerjaan_industri',
            'prodi' => 'array',
            'prodi.*.id_prodi' => [
                'required_with:prodi.*.matakuliah',
                'exists:program_studi,id_prodi',
                function (string $attribute, mixed $_, Closure $fail) {
                    
                    $parts = explode('.', $attribute);
                    $prodiIndex = (int) $parts[1]; 

                    
                    $prodiSubset = collect($this->input('prodi'))
                        ->slice(0, $prodiIndex + 1) 
                        ->pluck('id_prodi');
                    
                    $idProdiSaatIni = $this->input("prodi.$prodiIndex.id_prodi");
                    
                    $duplicateCount = $prodiSubset->filter(function ($id_prodi, $index) use ($idProdiSaatIni, $prodiIndex) {
                        return $id_prodi === $idProdiSaatIni && $index !== $prodiIndex;
                    })->count();

                    if ($duplicateCount > 0) {
                        $fail("Program studi sudah dipilih.");
                    }
                }
            ],
            'prodi.*.matakuliah' => 'required|array',
            'prodi.*.matakuliah.*.id_mk' => [
                'required',
                'required_with:prodi.*.id_prodi',
                'exists:mata_kuliah,id_mk',
                function (string $attribute, mixed $value, Closure $fail) {                    
                    $parts = explode('.', $attribute);
                    $prodiIndex = (int) $parts[1]; 
                    $matakuliahIndex = (int) $parts[3]; 
                    
                    // Ambil semua data 'id_mk' dari seluruh mata kuliah untuk prodi ini
                    $allMatakuliah = collect($this->input("prodi.$prodiIndex.matakuliah"))
                        ->slice(0, $matakuliahIndex + 1) // Hanya ambil subset hingga index saat ini
                        ->pluck('id_mk')
                        ->flatten(); // Flatten untuk mendapatkan satu list id_mk secara keseluruhan
            
                    // Ambil semua id_mk pada baris ini sebagai array
                    $currentIdMks = $this->input("prodi.$prodiIndex.matakuliah.$matakuliahIndex.id_mk");
            
                    // Cek setiap id_mk dalam array saat ini untuk melihat duplikasi pada subset data
                    foreach ($currentIdMks as $kodeMkSaatIni) {
                        // Hitung kemunculan id_mk tertentu pada subset
                        $duplicateCount = $allMatakuliah->filter(fn($id_mk) => $id_mk === $kodeMkSaatIni)->count();
            
                        // Jika ditemukan duplikasi lebih dari satu, buat pesan error dan hentikan pemeriksaan lebih lanjut
                        $duplicateMk = MataKuliah::find($kodeMkSaatIni);                        
                        if ($duplicateCount > 1) {                     
                            $fail("Mata kuliah '{$duplicateMk->kode_mk} - {$duplicateMk->namamk} - {$duplicateMk->sks}' sudah dipilih.");
                            return; // Hentikan pemeriksaan setelah menemukan kesalahan pertama
                        }
                    }
                }
            ],
            'prodi.*.matakuliah.*.bobot' => [
                'required_with:prodi.*.matakuliah',
                'required',
                'numeric',
                'min:1',
                'max:100',
                function (string $attribute, mixed $_, Closure $fail) {
                    // Ambil prodi dan matakuliah index dari attribute
                    $parts = explode('.', $attribute);
                    $prodiIndex = (int) $parts[1]; // Ambil index untuk prodi
                    $matakuliahIndex = (int) $parts[3]; // Ambil index untuk matakuliah

                    // Ambil semua bobot dari matakuliah saat ini hingga matakuliah yang sedang diinput
                    $matakuliahSubset = collect($this->input("prodi.$prodiIndex.matakuliah"))
                        ->slice(0, $matakuliahIndex + 1);

                    // Hitung total bobot dari matakuliah yang telah diinput hingga saat ini
                    $totalBobotSementara = $matakuliahSubset->sum('bobot');

                    // Ambil bobot untuk matakuliah yang sedang diinput
                    $bobotSaatIni = $this->input("prodi.$prodiIndex.matakuliah.$matakuliahIndex.bobot");

                    // Periksa apakah total bobot melebihi 100 secara berkala
                    if ($totalBobotSementara > 100) {

                        // Hitung sisa bobot yang bisa diisi
                        $availableBobot = 100 - ($totalBobotSementara - $bobotSaatIni);

                        if ($availableBobot <= 0) {
                            $fail("Maksimum bobot sudah tercapai.");
                        }

                        // Jika sisa bobot kurang dari bobot yang diinput, tampilkan pesan error
                        if ($availableBobot < $bobotSaatIni) {
                            $fail("Total bobot tidak boleh lebih dari 100. Sisa bobot yang tersedia: $availableBobot.");
                        }
                    }

                    // Jika ini adalah matakuliah terakhir dan total bobot kurang dari 100
                    if ($matakuliahIndex === (count($this->input("prodi.$prodiIndex.matakuliah")) - 1) && $totalBobotSementara < 100) {
                        $totalBobotSementara = 100 - ($totalBobotSementara - $bobotSaatIni);
                        $fail("Total bobot harus 100. Bobot tersedia: $totalBobotSementara.");
                    }
                }
            ],
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'id_bidang_pekerjaan_industri.required' => 'Bidang pekerjaan industri harus dipilih.',
            'id_bidang_pekerjaan_industri.exists' => 'Bidang pekerjaan industri tidak valid.',
            'prodi.required' => 'Prodi harus diisi.',
            'prodi.*.id_prodi.required' => 'Prodi harus dipilih.',
            'prodi.*.id_prodi.exists' => 'Prodi tidak valid.',
            'prodi.*.id_prodi.required_with' => 'Prodi harus dipilih',
            'prodi.*.matakuliah.required' => 'Mata kuliah harus diisi.',
            'prodi.*.matakuliah.*.id_mk.required' => 'Kode mata kuliah harus diisi.',
            'prodi.*.matakuliah.*.id_mk.exists' => 'Kode mata kuliah tidak valid.',
            'prodi.*.matakuliah.*.bobot.required' => 'Bobot nilai harus diisi.',
            'prodi.*.matakuliah.*.bobot.numeric' => 'Bobot nilai harus berupa angka.',
            'prodi.*.matakuliah.*.bobot.min' => 'Bobot nilai minimal 1.',
            'prodi.*.matakuliah.*.bobot.max' => 'Bobot nilai maksimal 100.',
        ];
    }
}
