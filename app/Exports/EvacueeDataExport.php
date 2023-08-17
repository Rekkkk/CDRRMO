<?php

namespace App\Exports;

use App\Models\Disaster;
use App\Models\Evacuee;
use App\Models\EvacuationCenter;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Style\Style as DefaultStyle;

class EvacueeDataExport implements FromView, ShouldAutoSize, WithStyles, WithDefaultStyles
{
    use Exportable;

    private $evacuee, $evacueeData, $onGoingDisaster, $totalEvacuationCenter, $total, $totalFamilies, $totalIndividuals, $totalMale, $totalFemale, $totalSeniorCitizen, $totalMinors, $totalInfants, $totalPwd, $totalPregnant, $totalLactating;

    public function __construct($disasterId)
    {
        $this->evacuee = new Evacuee;
        $this->evacueeData = $this->evacuee->where('disaster_id', $disasterId)->get();
        $this->onGoingDisaster = Disaster::where('id', $disasterId)->value('name');
        $this->totalEvacuationCenter = EvacuationCenter::where('status', 'Active')->count();
        $this->total = $this->evacuee->where('disaster_id', $disasterId)->selectRaw('SUM(families) as totalFamilies, SUM(individuals) as totalIndividuals, SUM(male) as totalMale, SUM(female) as totalFemale, SUM(senior_citizen) as totalSeniorCitizen, SUM(minors) as totalMinors, SUM(infants) as totalInfants, SUM(pwd) as totalPwd, SUM(pregnant) as totalPregnant, SUM(lactating) as totalLactating');
        $computedData = $this->total->first();
        $this->totalFamilies = $computedData['totalFamilies'];
        $this->totalIndividuals = $computedData['totalIndividuals'];
        $this->totalMale = $computedData['totalMale'];
        $this->totalFemale = $computedData['totalFemale'];
        $this->totalSeniorCitizen = $computedData['totalSeniorCitizen'];
        $this->totalMinors = $computedData['totalMinors'];
        $this->totalInfants = $computedData['totalInfants'];
        $this->totalPwd = $computedData['totalPwd'];
        $this->totalPregnant = $computedData['totalPregnant'];
        $this->totalLactating = $computedData['totalLactating'];
    }

    public function view(): View
    {
        return view('userpage.evacuee.evacueeDataExcel', [
            'evacueeData' => $this->evacueeData,
            'onGoingDisaster' => $this->onGoingDisaster,
            'totalEvacuationCenter' => $this->totalEvacuationCenter,
            'totalFamilies' => $this->totalFamilies,
            'totalIndividuals' => $this->totalIndividuals,
            'totalMale' => $this->totalMale,
            'totalFemale' => $this->totalFemale,
            'totalSeniorCitizen' => $this->totalSeniorCitizen,
            'totalMinors' => $this->totalMinors,
            'totalInfants' => $this->totalInfants,
            'totalPwd' => $this->totalPwd,
            'totalPregnant' => $this->totalPregnant,
            'totalLactating' => $this->totalLactating
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $header = 'A6:' . $highestColumn . '6';

        $mergedCells = ['A1:N1', 'A2:N2', 'A3:N3', 'A4:N4', 'A5:N5'];

        foreach ($mergedCells as $cellRange) {
            $sheet->mergeCells($cellRange);
            $sheet->getStyle($cellRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->getStyle('A' . $highestRow . ':' . $highestColumn . $highestRow)->getFont()->setBold(true);
        $sheet->getRowDimension(5)->setRowHeight(20);

        $sheet->getStyle($header)->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($header)->getFill()->getStartColor()->setRGB('fde047');
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $sheet->getRowDimension(6)->setRowHeight(40);
        $sheet->getStyle('6')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A6:A' . $highestRow)->getFont()->setBold(true);
        $sheet->getStyle('B6:B' . $highestRow)->getFont()->setBold(true);
        $sheet->getStyle('C6:C' . $highestRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getCell('A6')->getStyle()->getAlignment()->setWrapText(true);

        $sheet->getStyle('A7:' . $highestColumn . $highestRow)->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A7:' . $highestColumn . $highestRow)->getFill()->getStartColor()->setRGB('fef9c3');

        for ($row = 7; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        $sheet->getStyle('A' . $highestRow . ':' . $highestColumn . $highestRow)->getFill()->getStartColor()->setRGB('fde047');
    }

    public function defaultStyles(DefaultStyle $defaultStyle)
    {
        return [
            'font' => [
                'name' => 'Calibri',
                'size' => 8.5,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];
    }
}
