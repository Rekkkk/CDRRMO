<?php

namespace App\Exports;

use App\Models\Evacuee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EvacueeDataExport implements FromView, ShouldAutoSize
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
}
