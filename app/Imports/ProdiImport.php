<?php

namespace App\Imports;

use App\Imports\DataCleaning;
use App\Models\Fakultas;
use App\Models\Universitas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\HeadingRowImport;

class ProdiImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    use Importable;
    protected Universitas $univ;    
    protected Fakultas $fakultas;
    protected string $primaryKey = "";
    protected string $model = 'program_studi';
    protected array $fields = [
        'jenjang' => 'jenjang|uppercase',        
        'namaprodi' => 'nama_program_studi|capitalize',
    ];    
    protected array $specialModelDb = [];    
    protected $additionalData;
    protected $dataCleaning;
    protected $newData;
    protected $duplicatedData;
    protected $failedData;

    public function __construct($id_univ, $id_fakultas)
    {
        $this->univ = Universitas::findOrFail($id_univ, ['id_univ', 'namauniv']);
        $this->fakultas = Fakultas::findOrFail($id_fakultas, ['id_fakultas', 'namafakultas']);        

        $this->additionalData = [
            'id_univ' => $this->univ->id_univ,
            'id_fakultas' => $this->fakultas->id_fakultas,            
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
                'namaprodi' => 'required|string|max:255',
                'jenjang' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $validOptions = ['D3', 'D4', 'S1'];
                        if (!in_array(strtoupper($value), $validOptions)) {
                            $fail("Jenjang tidak valid, mohon isi diantara D3, D4, S1");
                        }
                    }
                ],             
            ],
            [
                '*.required' => 'Data Kosong',                
                '*.string' => 'Data Tidak Sesuai',                
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
        ];
    }
}
