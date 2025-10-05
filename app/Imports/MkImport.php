<?php

namespace App\Imports;

use App\Imports\DataCleaning;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Models\Universitas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\HeadingRowImport;

class MkImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    use Importable;
    protected Universitas $univ;
    protected Fakultas $fakultas;
    protected ProgramStudi $prodi;
    protected string $primaryKey = "kode_mk";
    protected string $model = 'mata_kuliah';
    protected array $fields = [
        'kode_mk' => 'kode_matakuliah|uppercase',
        'namamk' => 'nama_matakuliah|capitalize',
        'sks' => 'sks',
    ];
    
    protected array $specialModelDb = [
        'mata_kuliah' => 'namamk|namamk|restrict',       
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
                'kode_mk' => 'required|string|max:18',
                'namamk' => 'required|string|max:255',
                'sks' => 'required|integer|between:1,12',
            ],
            [
                '*.required' => 'Data Kosong',
                '*.integer' => 'Data Tidak Sesuai',
                '*.string' => 'Data Tidak Sesuai',
                'sks.between' => 'SKS harus di antara 0 hingga 12',
                'kode_mk.max' => 'Kode MK maksimal 18 karakter',
                'namamk.max' => 'Nama Matakuliah maksimal 255 karakter',
            ],
            $this->model,
            $this->specialModelDb,
            $this->additionalData,
            true

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
        ];
    }
}
