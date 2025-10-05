<?php

namespace App\Exports;

class NilaiMhsMagangFakultasExport extends BaseExport
{
    protected $columns = [
        'Nama Mahasiswa' => ['typeValue' => 'text', 'key' => 'namamhs'],
        'NIM' => ['typeValue' => 'text', 'key' => 'nim'],
        'Program Studi' => ['typeValue' => 'text', 'key' => 'namaprodi'],
        'Perusahaan' => ['typeValue' => 'text', 'key' => 'namaindustri'],
        'Posisi Magang' => ['typeValue' => 'text', 'key' => 'intern_position'],
        'Nilai PBB Lapangan' => ['align' => 'center', 'typeValue' => 'decimal', 'key' => 'nilai_lap'],
        'Nilai PBB Akademik' => ['align' => 'center', 'typeValue' => 'decimal', 'key' => 'nilai_akademik'],
        'Nilai Akhir' => ['align' => 'center', 'typeValue' => 'decimal', 'key' => 'nilai_akhir_magang'],
        'Indeks Nilai Akhir' => ['typeValue' => 'text', 'key' => 'indeks_nilai_adjust|indeks_nilai_akhir'],
    ];

    public function __construct($data, $fileName = null, $templateFileName = "Template_Nilai_Akhir_Mhs_Magang_Fakultas")
    {
        $this->data = $data;
        $this->templateFileName = $templateFileName;
        $this->fileName = $fileName ?? 'Export_Nilai_Akhir_Mhs_Magang_Fakultas_' . now()->format('d_M_Y') . '.xlsx';

        parent::__construct($data, $this->columns, $this->fileName, $this->templateFileName);
    }
}
