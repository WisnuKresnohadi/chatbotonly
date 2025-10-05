<?php

namespace App\Exports;

class DosenExport extends BaseExport
{
    protected $columns = [
        'NIP' => ['typeValue' => 'text', 'key' => 'nip'],
        'Kode Dosen' => ['align' => 'center', 'typeValue' => 'text', 'key' => 'kode_dosen'],
        'Nama Dosen' => ['typeValue' => 'text', 'key' => 'namadosen'],
        'No Telp' => ['typeValue' => 'text', 'key' => 'nohpdosen'],
        'Email' => ['typeValue' => 'email', 'key' => 'emaildosen'],
    ];

    public function __construct($data, $fileName = null, $templateFileName = "Template_Import_Dosen")
    {
        $this->data = $data;
        $this->templateFileName = $templateFileName;
        $this->fileName = $fileName ?? 'Export_Dosen_' . now()->format('d_M_Y') . '.xlsx';

        parent::__construct($data, $this->columns, $this->fileName, $this->templateFileName);
    }
}
