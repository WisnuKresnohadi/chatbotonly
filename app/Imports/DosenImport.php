<?php

namespace App\Imports;

use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\Universitas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\HeadingRowImport;

class DosenImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    use Importable;
    protected Universitas $univ;
    protected Fakultas $fakultas;
    protected ProgramStudi $prodi;
    protected string $primaryKey = "nip";
    protected array $specialModelDb = [
        'dosen' => [
            "emaildosen|emaildosen",
            "kode_dosen|kode_dosen"
        ],
        'mahasiswa' => 'emailmhs|emaildosen',
        'pegawai_industri' => 'emailpeg|emaildosen',
        'industri' => 'email|emaildosen',
        'users' => 'email|emaildosen',
    ];
    protected string $table = 'dosen';
    protected array $fields = [
        'nip' => 'nip',
        'kode_dosen' => 'kode_dosen|uppercase',
        'namadosen' => 'nama_dosen|capitalize',
        'nohpdosen' => 'no_telp',
        'emaildosen' => 'email|lowercase'
    ];
    protected $additionalData;
    protected $dataCleaning;
    protected $newData;
    protected $duplicatedData;
    protected $failedData;

    public function __construct($id_univ, $id_fakultas, $id_prodi)
    {
        $this->univ = Universitas::findOrFail($id_univ, ['id_univ', 'namauniv']);
        $this->fakultas = Fakultas::findOrFail($id_fakultas, ['id_fakultas', 'namafakultas']);
        $this->prodi = ProgramStudi::findOrFail($id_prodi, ['id_prodi', 'namaprodi']);

        $this->additionalData = [
            'id_univ' => $this->univ->id_univ,
            'id_fakultas' => $this->fakultas->id_fakultas,
            'id_prodi' => $this->prodi->id_prodi,
        ];

        $this->dataCleaning = new DataCleaning(
            $this->primaryKey,
            array_values($this->fields),
            array_keys($this->fields),
            [
                'nip' => 'required|string',
                'kode_dosen' => 'required|string|max:5',
                'namadosen' => 'required|string|max:255',
                'nohpdosen' => 'required|string|max:15',
                'emaildosen' => 'required|string|email',
            ],
            [
                '*.required' => 'Data Kosong',
                '*.numeric' => 'Data Tidak Sesuai',
                '*.integer' => 'Data Tidak Sesuai',
                '*.between' => 'Data Tidak Sesuai',
                '*.string' => 'Data Tidak Sesuai',
                '*.email' => 'Data Tidak Sesuai',
                'kode_dosen.max' => 'Kode Dosen maksimal 5 karakter',
                'namadosen.max' => 'Nama Dosen maksimal 255 karakter',
                'nohpdosen.max' => 'No Telp maksimal 15 karakter',
                'emaildosen.max' => 'Email maksimal 255 karakter',
            ],
            $this->table,
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

    public function getNewData()
    {
        return $this->newData;
    }

    public function getDuplicatedData()
    {
        return $this->duplicatedData;
    }

    public function getFailedData()
    {
        return $this->failedData;
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
        ];
    }
}
