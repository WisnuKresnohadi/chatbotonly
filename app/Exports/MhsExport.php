<?php

namespace App\Exports;

class MhsExport extends BaseExport
{
    protected $columns = [
        'NIM' => ['typeValue' => 'text', 'key' => 'nim'],
        'Tunggakan BPP' => ['align' => 'center', 'typeValue' => 'text', 'key' => 'tunggakan_bpp'],
        'IPK' => ['align' => 'center', 'typeValue' => 'decimal', 'key' => 'ipk'],
        'EPRT' => ['align' => 'center', 'typeValue' => 'decimal', 'key' => 'eprt'],
        'TAK' => ['align' => 'center', 'typeValue' => 'decimal', 'key' => 'tak'],
        'Angkatan' => ['align' => 'center', 'typeValue' => 'integer', 'key' => 'angkatan'],
        'Nama Mahasiswa' => ['align' => 'center', 'key' => 'namamhs'],
        'No HP' => ['align' => 'center', 'key' => 'nohpmhs'],
        'Email' => ['align' => 'center', 'key' => 'emailmhs'],
        'Alamat' => ['align' => 'center', 'key' => 'alamatmhs'],
    ];

    public function __construct($data, $fileName = null, $templateFileName = "Template_Import_Mahasiswa")
    {
        $this->data = $data;
        $this->templateFileName = $templateFileName;
        $this->fileName = $fileName ?? 'Export_Mahasiswa_' . now()->format('d_M_Y') . '.xlsx';

        parent::__construct($data, $this->columns, $this->fileName, $this->templateFileName);
    }
}
