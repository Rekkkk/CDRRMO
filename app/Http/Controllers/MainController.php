<?php

namespace App\Http\Controllers;

use App\Models\Typhoon;
use App\Models\Evacuee;
use App\Models\Disaster;
use App\Models\Flashflood;
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
        $evacuee = new Evacuee;
        $disaster = new Disaster;

        $onGoingDisaster = $disaster->where('status', "On Going")->get();
        $activeEvacuation = $this->evacuationCenter->where('status', 'Active')->count();
        $inEvacuationCenter = $evacuee->whereNull('date_out')->count();

        return view('userpage.dashboard',  compact('activeEvacuation', 'inEvacuationCenter', 'onGoingDisaster'));
    }

    public function generateExcelEvacueeData()
    {
        return Excel::download(new EvacueeDataExport, 'evacuee-data.xlxs', ExcelExcel::XLSX);
    }

    public function manageEvacueeInformation(Request $request)
    {
        $disaster = new Disaster;

        $evacuationList = $this->evacuationCenter->all();
        $typhoonList =  Typhoon::all();
        $flashfloodList = Flashflood::all()->where('status', 'Rising');
        $disasterList = null;

        if ($typhoonList->isNotEmpty() && $flashfloodList->isNotEmpty()) {
            $disasterList = $disaster->all();
        } else if ($typhoonList->isNotEmpty()) {
            $disasterList = $disaster->where('id', 1)->get();
        } else if ($flashfloodList->isNotEmpty()) {
            $disasterList = $disaster->where('id', 2)->get();
        }

        return view('userpage.evacuee.evacuee', compact('evacuationList', 'disasterList', 'typhoonList', 'flashfloodList'));
    }

    public function evacuationCenterLocator()
    {
        $evacuationCenters = $this->evacuationCenter->all();

        return view('userpage.evacuationCenter.evacuationCenter', ['evacuationCenters' => $evacuationCenters]);
    }

    public function manageEvacuation()
    {
        return view('userpage.evacuationCenter.manageEvacuation');
    }

    public function reportAccident()
    {
        return view('userpage.reportAccident');
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
