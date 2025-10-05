<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\Universitas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\HeadingRowImport;

class MhsImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    use Importable;
    protected Universitas $univ;
    protected Fakultas $fakultas;
    protected ProgramStudi $prodi;
    protected Dosen $dosenWali;
    protected string $primaryKey = "nim";
    protected array $specialModelDb = [
        'mahasiswa' => 'emailmhs|emailmhs',
        'dosen' => "emaildosen|emailmhs",
        'pegawai_industri' => 'emailpeg|emailmhs',
        'industri' => 'email|emailmhs',
        'users' => 'email|emailmhs',
    ];
    protected string $model = 'mahasiswa';
    protected array $fields = [
        'nim' => 'nim',
        'tunggakan_bpp' => 'tunggakan_bpp',
        'ipk' => 'ipk',
        'tesbahasa' => 'eprt',
        'tak' => 'tak',
        'angkatan' => 'angkatan',
        'namamhs' => 'nama_mahasiswa|capitalize',
        'nohpmhs' => 'no_hp',
        'emailmhs' => 'email|lowercase',
        'alamatmhs' => 'alamat'
    ];

    protected $additionalData;
    protected $dataCleaning;
    protected $newData;
    protected $duplicatedData;
    protected $failedData;

    // Constructor Utama dengan parameter
    public function __construct($id_univ, $id_fakultas, $id_prodi, $kode_dosen)
    {
        $this->univ = Universitas::findOrFail($id_univ, ['id_univ', 'namauniv']);
        $this->fakultas = Fakultas::findOrFail($id_fakultas, ['id_fakultas', 'namafakultas']);
        $this->prodi = ProgramStudi::findOrFail($id_prodi, ['id_prodi', 'namaprodi']);
        $this->dosenWali = Dosen::where('kode_dosen', $kode_dosen)->firstOrFail(['kode_dosen', 'namadosen']);

        $this->additionalData = [
            'id_univ' => $this->univ->id_univ,
            'id_fakultas' => $this->fakultas->id_fakultas,
            'id_prodi' => $this->prodi->id_prodi,
            'kode_dosen' => $this->dosenWali->kode_dosen
        ];

        $this->initializeDataCleaning();
    }

    private function initializeDataCleaning()
    {
        $this->dataCleaning = new DataCleaning(
            $this->primaryKey,
            array_values($this->fields),
            array_keys($this->fields),
            [
                'nim' => 'required|string|max:18',
                'tunggakan_bpp' => ['required', function ($attribute, $value, $fail) {
                    if (!in_array(strtolower($value), ['iya', 'tidak'])) {
                        $fail('Tunggakan BPP harus diisi dengan Iya atau Tidak');
                    }
                }],
                'ipk' => 'required|numeric|between:0,4.00',
                'eprt' => 'required|integer|between:0,677',
                'tak' => 'required|integer',
                'angkatan' => 'required|integer',
                'namamhs' => 'required|string|max:255',
                'nohpmhs' => 'required|string|max:15',
                'emailmhs' => 'required|string|email',
                'alamatmhs' => 'required|string'
            ],
            [
                '*.required' => 'Data Kosong',
                '*.numeric' => 'Data Tidak Sesuai',
                '*.integer' => 'Data Tidak Sesuai',
                '*.string' => 'Data Tidak Sesuai',
                '*.email' => 'Data Tidak Sesuai',
                'tunggakan_bpp.in' => 'Tunggakan BPP harus diisi dengan Iya atau Tidak',
                'ipk.between' => 'IPK harus di antara 0 hingga 4.00',
                'eprt.between' => 'EPRT harus di antara 0 hingga 677',
                'nim.max' => 'NIM maksimal 18 karakter',
                'namamhs.max' => 'Nama Mahasiswa maksimal 255 karakter',
                'nohpmhs.max' => 'No Telp maksimal 15 karakter',
            ],
            $this->model,
            $this->specialModelDb,
            $this->additionalData
        );

        $this->newData = collect();
        $this->duplicatedData = collect();
        $this->failedData = collect();
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }

    public function collection(Collection $rows)
    {
        $this->dataCleaning->collection($rows);
        $this->dataCleaning->cleanDuplicateData();
        $this->newData = $this->dataCleaning->getNewData();
        $this->duplicatedData = $this->dataCleaning->getDuplicatedData();
        $this->failedData = $this->dataCleaning->getFailedData();
    }

    public function checkHeaders($filePath)
    {
        $data = (new HeadingRowImport())->toArray($filePath);
        $headers = array_slice($data[0][0], 0, count($this->fields));
        return $headers === preg_replace('/\|.*/', '', array_values($this->fields));
    }

    public function getResults(): array
    {
        return [
            'newData' => $this->newData,
            'duplicatedData' => $this->duplicatedData,
            'failedData' => $this->failedData,
            'univ' => $this->univ,
            'fakultas' => $this->fakultas,
            'prodi' => $this->prodi,
            'dosen_wali' => $this->dosenWali ?? null,
        ];
    }
}
