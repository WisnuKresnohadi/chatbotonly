<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataFailedExport
{
    protected $templateFileName;
    protected $failedData;
    protected $fileName;

    public function __construct($templateFileName, $failedData, $fileName = 'data_failed_import')
    {
        $this->templateFileName = public_path('/template-excel/' . $templateFileName . '.xlsx');
        $this->failedData = $failedData;
        $this->fileName = $fileName . '.xlsx';
    }

    public function download()
    {
        $spreadsheet = IOFactory::load($this->templateFileName);

        $sheet = $spreadsheet->getActiveSheet();

        $sheetData = $sheet->toArray();        
        
        $headerRow = $sheetData[0];
        
        $headerCount = array_reduce($headerRow, function ($carry, $item) {
            if ($item === null || $item === '') {
                return $carry; 
            }
            return $carry + 1; 
        }, 0);
        
        $this->fillData($sheet, $headerCount);
        // $this->applyProtectionStyle($sheet);

        return $this->streamResponse($spreadsheet);
    }

    protected function fillData($sheet, $maxIndex)
    {
        $column = "A";
        $row = 2;
        foreach ($this->failedData as $error) {
            $index = 0;
            foreach ($error as $value) {      
                if($index + 1 > $maxIndex) break;                   
                $sheet->setCellValue($column . $row, $value);
                $column++;
                $index++;
            }
            $index = 0;
            $column = "A";
            $row++;
        }
    }

    protected function applyProtectionStyle($sheet)
    {
        $fillStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'A5A5A5']
            ]
        ];
        $sheet->getStyle("{$sheet->getHighestColumn()}:XFD")->applyFromArray($fillStyle);
    }

    protected function streamResponse($spreadsheet)
    {
        $writer = new Xlsx($spreadsheet);

        return new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $this->fileName . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}

// use Maatwebsite\Excel\Concerns\WithEvents;
// use Maatwebsite\Excel\Events\AfterSheet;

// class DataFailedExport implements WithEvents
// {
//     protected array $failedData;
//     protected array $requiredFields;
//     protected string $templateFile;

//     public function __construct($templateFile, $failedData)
//     {
//         $this->failedData = $failedData;
//         $this->templateFile = $templateFile;
//     }

//     public function registerEvents(): array
//     {
//         return [
//             AfterSheet::class => function (AfterSheet $event) {
//                 $workSheet = $event->sheet->getDelegate();

//                 $template = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('/template-excel/' . $this->templateFile));
//                 $templateSheet = $template->getActiveSheet();

//                 $workSheet->fromArray($templateSheet->toArray(), null, 'A1');

//                 // Salin pengaturan lebar kolom
//                 foreach ($templateSheet->getColumnDimensions() as $colChar => $dimension) {
//                     if ($dimension->getWidth() !== -1) {
//                         $workSheet->getColumnDimension($colChar)->setWidth($dimension->getWidth());
//                     }
//                     if ($dimension->getAutoSize()) {
//                         $workSheet->getColumnDimension($colChar)->setAutoSize(true);
//                     }
//                 }

//                 // Salin pengaturan tinggi baris
//                 foreach ($templateSheet->getRowDimensions() as $rowIndex => $dimension) {
//                     if ($dimension->getRowHeight() !== -1) {
//                         $workSheet->getRowDimension($rowIndex)->setRowHeight($dimension->getRowHeight());
//                     }
//                 }

//                 $highestColumn = ord($workSheet->getHighestColumn()) - 1;
//                 $highestRow = $workSheet->getHighestRow();
//                 $highestColumn = chr($highestColumn);                                

//                 // 1. Beri unprotected ke semua kolom
//                 $workSheet->getStyle("A:{$highestColumn}")->getProtection()
//                     ->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

//                 // 2. Beri protected ke header (asumsikan header di baris pertama)
//                 $workSheet->getStyle("A1:{$highestColumn}{$highestRow}")->getProtection()
//                     ->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);

//                 // 3. Beri style accent 3 pada kolom yang diproteksi
//                 $fillStyle = [
//                     'fill' => [
//                         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//                         'color' => ['argb' => 'A5A5A5'] // Warna Accent 3 Light
//                     ]
//                 ];

//                 $workSheet->getStyle("{$workSheet->getHighestColumn()}:XFD")->applyFromArray($fillStyle);

//                 // Salin pengaturan gaya sel
//                 $workSheet->duplicateStyle($templateSheet->getStyle('A1:' . $highestColumn . $templateSheet->getHighestRow()), 'A1:' . $highestColumn . $workSheet->getHighestRow());

//                 // 4. Set proteksi worksheet
//                 $workSheet->getProtection()->setSheet(true);

//                 // Atur password untuk proteksi worksheet (opsional)
//                 $workSheet->getProtection()->setPassword('password');
//             },
//         ];
//     }
// }
