<?php

namespace App\Http\Controllers;

use App\Models\Evacuee;
use App\Models\Disaster;
use Illuminate\Http\Request;
use App\Models\EvacuationCenter;
use App\Exports\EvacueeDataExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class MainController extends Controller
{
    private $evacuationCenter;

    public function __construct()
    {
        $this->evacuationCenter = new EvacuationCenter;
    }
    public function dashboard()
    {
        $onGoingDisaster = Disaster::where('status', "On Going")->get();
        $activeEvacuation = $this->evacuationCenter->where('status', 'Active')->count();
        $inEvacuationCenter = Evacuee::count();

        return view('userpage.dashboard',  compact('activeEvacuation', 'inEvacuationCenter', 'onGoingDisaster'));
    }

    public function generateExcelEvacueeData()
    {
        return Excel::download(new EvacueeDataExport, 'evacuee-data.xlxs', ExcelExcel::XLSX);
    }

    public function manageEvacueeInformation(Request $request)
    {
        $disasterList = Disaster::where('status', 'On Going')->get();
        $evacuationList = $this->evacuationCenter->all();

        return view('userpage.evacuee.evacuee', compact('evacuationList', 'disasterList'));
    }

    public function evacuationCenterLocator()
    {
        $evacuationCenters = $this->evacuationCenter->all();
        $prefix = Request()->route()->getPrefix();

        return view('userpage.evacuationCenter.evacuationCenter', compact('evacuationCenters', 'prefix'));
    }

    public function manageEvacuation()
    {
        return view('userpage.evacuationCenter.manageEvacuation');
    }

    public function incidentReport()
    {
        return view('userpage.incidentReport');
    }

    public function hotlineNumber()
    {
        return view('userpage.hotlineNumbers');
    }

    public function about()
    {
        return view('userpage.about');
    }
}
