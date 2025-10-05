<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DataMahasiswaMagangExport implements FromCollection, WithHeadings, WithEvents
{
    protected $query;
    protected $headings;

    public function __construct($query,$headings)
    {
        $this->query = $query;
        $this->headings = $headings;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->query;
    }

    public function headings(): array{
        return $this->headings;
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $lastRow; $row++) {
                    $cellValue = $sheet->getCell("J{$row}")->getValue();
                    if (!empty($cellValue)) {
                        $url = asset('storage/' . $cellValue);
                        $sheet->getCell("J{$row}")->setHyperlink(new Hyperlink($url, 'View Document'));
                        $sheet->getCell("J{$row}")->setValue('View Document');
                        $sheet->getStyle("J{$row}")->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE));
                        $sheet->getStyle("J{$row}")->getFont()->setUnderline(true);
                    }
                }
            },
        ];
    }
}
