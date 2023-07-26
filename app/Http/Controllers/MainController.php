<?php

namespace App\Http\Controllers;

use App\Models\Evacuee;
use App\Models\Disaster;
use Illuminate\Http\Request;
use App\Models\EvacuationCenter;
use App\Exports\EvacueeDataExport;
use App\Models\Reporting;
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
        $totalEvacuee = 0;
        $disasterData = [];

        foreach ($onGoingDisaster as $count => $disaster) {
            $totalEvacueeCount = Evacuee::where('disaster_name', $disaster->name)->sum('individuals');
            $result = Evacuee::where('disaster_name', $disaster->name)
                ->selectRaw('SUM(male) as totalMale, 
                 SUM(female) as totalFemale, 
                 SUM(senior_citizen) as totalSeniorCitizen, 
                 SUM(minors) as totalMinors, 
                 SUM(infants) as totalInfants, 
                 SUM(pwd) as totalPwd, 
                 SUM(pregnant) as totalPregnant, 
                 SUM(lactating) as totalLactating')
                ->first();

            $disasterData[$count]['disasterName'] = $disaster->name;
            $totalEvacuee += $totalEvacueeCount;
            $disasterData[$count]['totalMale'] = $result->totalMale;
            $disasterData[$count]['totalFemale'] = $result->totalFemale;
            $disasterData[$count]['totalSeniorCitizen'] = $result->totalSeniorCitizen;
            $disasterData[$count]['totalMinors'] = $result->totalMinors;
            $disasterData[$count]['totalInfants'] = $result->totalInfants;
            $disasterData[$count]['totalPwd'] = $result->totalPwd;
            $disasterData[$count]['totalPregnant'] = $result->totalPregnant;
            $disasterData[$count]['totalLactating'] = $result->totalLactating;
        }

        return view('userpage.dashboard',  compact('activeEvacuation', 'disasterData', 'totalEvacuee', 'onGoingDisaster'));
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
        $incidentReport = Reporting::whereNotIn('status', ["On Process"])->where('is_archive', 0)->get();

        return view('userpage.incidentReport', compact('incidentReport'));
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
