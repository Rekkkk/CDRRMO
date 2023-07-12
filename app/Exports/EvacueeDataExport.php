<?php

namespace App\Exports;

use App\Models\Evacuee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style as DefaultStyle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EvacueeDataExport implements FromView, ShouldAutoSize, WithStyles, WithDefaultStyles
{
    use Exportable;
    private $evacueeData;

    public function __construct()
    {
        $this->evacueeData = Evacuee::all();
    }
    public function view(): View
    {
        return view('userpage.evacueeDataExcel', [
            'evacueeData' => $this->evacueeData
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $header = 'A1:' . $highestColumn . '1';

        $sheet->getStyle($header)->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($header)->getFill()->getStartColor()->setRGB('fde047');
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $sheet->getRowDimension(1)->setRowHeight(60);
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('A')->getFont()->setBold(true);
        $sheet->getStyle('N')->getFont()->setBold(true);
        $sheet->getStyle('A' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getCell('A1')->getStyle()->getAlignment()->setWrapText(true);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getStyle('A2:' . $highestColumn . $highestRow)->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A2:' . $highestColumn . $highestRow)->getFill()->getStartColor()->setRGB('fef9c3');

        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(30);
        }

        for ($col = 6; $col <= 12; $col++) {
            $cellCoordinate = Coordinate::stringFromColumnIndex($col) . '1';
            $sheet->getStyle($cellCoordinate)->getAlignment()->setTextRotation(90);
        }

        $sheet->getStyle('B1:B1')->getAlignment()->setTextRotation(90);
    }

    public function defaultStyles(DefaultStyle $defaultStyle)
    {
        return [
            'font' => [
                'name' => 'Calibri',
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];
    }
}
