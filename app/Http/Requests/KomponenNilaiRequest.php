<?php

namespace App\Http\Requests;

use App\Helpers\Response;
use App\Models\JenisMagang;
use App\Models\KomponenNilai;
use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use JsonSchema\Exception\ValidationException;

class KomponenNilaiRequest extends FormRequest
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
            'id_jenismagang' => ['required'],
            'komponen.*.aspek_penilaian' => ['required'],
            'komponen.*.deskripsi_penilaian' => ['required'],
            'komponen.*.scored_by' => ['required', 'in:1,2'],
            'komponen.*.nilai_max' => [
            'required',
            'numeric',
                function (string $attribute, mixed $_, Closure $fail) {        
                    $parts = explode('.', $attribute);        
                    $currentIndex = (int) $parts[1];        
                    //id magang
                    $idJenisMagang = $this->input('id_jenismagang');     
                    // input score by   
                    $scoredBy = $this->input("komponen.$currentIndex.scored_by");
                    
                    // Komponen nilai -> status, scoredby
                    $komponenNilai = KomponenNilai::where('komponen_nilai.id_jenismagang', $idJenisMagang)
                            ->where('komponen_nilai.status', 1)
                            ->where('komponen_nilai.scored_by', $scoredBy)
                            ->get();
                    // jenis magang        
                    $jenisMagang = JenisMagang::where('id_jenismagang', $idJenisMagang)->first();
                    
                    // total nilai max di db
                    $totalNilaiMaxDb = $komponenNilai->sum(function ($item) {
                        return $this->id && $item->id_kompnilai == $this->id ? 0 : $item->nilai_max;
                    });        

                    // validasi jika nilai maks sudah 100
                    if($totalNilaiMaxDb == 100) throw new \Exception("Nilai maksimal sudah 100 untuk <br>{$jenisMagang->namajenis}.");
                        
                    // input nilai max -> scored by
                    $komponenInputs = collect($this->input('komponen'))->where('scored_by', $scoredBy);

                    // current total
                    $currenTotal = $totalNilaiMaxDb;

                    // iterasi untuk validasi
                    $komponenInputs->each(function ($input, $index) use ($totalNilaiMaxDb, &$currenTotal, $currentIndex, $fail) {                        
                        $currenTotal += $input['nilai_max'];        
                        $totalAvailable = isset($this->id) ? (100 - $totalNilaiMaxDb) : (100 - ($currenTotal - $input['nilai_max']));

                        // validasi current total > 100
                        if ($currenTotal > 100) {
                            // validasi tampilkan nilai tersedia sesuai index input dan total available masih ada
                            if ($index == $currentIndex && ($totalAvailable > 0)) {
                                $fail("Nilai maksimal tidak bisa lebih dari 100, nilai maksimal tersedia $totalAvailable.");
                            
                            // validasi ketika total available sudah 0
                            } elseif ($index < $currentIndex) {                                
                                $fail("Nilai maksimal tidak bisa lebih dari 100");
                                return false;
                            }
                        }
                            
                        // validasi ketika total available sudah 0
                        if ($currenTotal > 100 && $index == $currentIndex) {
                            $fail("Nilai maksimal tidak bisa lebih dari 100");                            
                        }
                    }); 
                },
            ]
        ];
    }

    public function messages()
    {
        return [
            'id_jenismagang.required' => 'Jenis Magang harus diisi',
            'komponen.*.aspek_penilaian.required' => 'Aspek Penilaian harus diisi',
            'komponen.*.deskripsi_penilaian.required' => 'Deskripsi Penilaian harus diisi',
            'komponen.*.scored_by.required' => 'Pilih salah satu.',
            'komponen.*.nilai_max.required' => 'Nilai Maksimal harus diisi',            
        ];
    }
}
