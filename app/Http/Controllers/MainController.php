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

        $activeEvacuation = $this->evacuationCenter->where('status', 'Active')->count();
        $inActiveEvacuation = $this->evacuationCenter->where('status', 'Inactive')->count();

        $inEvacuationCenter = $evacuee->whereNull('date_out')->count();
        $isReturned = $evacuee->whereNotNull('date_out')->count();

        $typhoonData = $evacuee->countEvacueeWithDisablities('Typhoon');
        $typhoon4Ps = intval($typhoonData[0]->{'fourps'});
        $typhoonPWD = intval($typhoonData[0]->PWD);
        $typhoonPregnant = intval($typhoonData[0]->pregnant);
        $typhoonLactating = intval($typhoonData[0]->lactating);
        $typhoonStudent = intval($typhoonData[0]->student);
        $typhoonWorking = intval($typhoonData[0]->working);

        $floodingData = $evacuee->countEvacueeWithDisablities('Flashflood');
        $flooding4Ps = intval($floodingData[0]->{'fourps'});
        $floodingPWD = intval($floodingData[0]->PWD);
        $floodingPregnant = intval($floodingData[0]->pregnant);
        $floodingLactating = intval($floodingData[0]->lactating);
        $floodingStudent = intval($floodingData[0]->student);
        $floodingWorking = intval($floodingData[0]->working);

        $statisticData = compact(
            'activeEvacuation',
            'inActiveEvacuation',
            'inEvacuationCenter',
            'isReturned',
            'typhoon4Ps',
            'typhoonPWD',
            'typhoonPregnant',
            'typhoonLactating',
            'typhoonStudent',
            'typhoonWorking',
            'flooding4Ps',
            'floodingPWD',
            'floodingPregnant',
            'floodingLactating',
            'floodingStudent',
            'floodingWorking'
        );

        $statisticData['typhoonMaleData'] = $evacuee->countEvacuee('Typhoon', 'Male');
        $statisticData['typhoonFemaleData'] = $evacuee->countEvacuee('Typhoon', 'Female');
        $statisticData['floodingMaleData'] = $evacuee->countEvacuee('Flooding', 'Male');
        $statisticData['floodingFemaleData'] = $evacuee->countEvacuee('Flooding', 'Female');

        return view('userpage.dashboard',  $statisticData);
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
        $evacuationCenter = $this->evacuationCenter->all();

        $initialMarkers = [
            [
                'position' => [
                    'lat' => 28.625485,
                    'lng' => 79.821091
                ],
                'label' => ['color' => 'white', 'text' => 'P1'],
                'draggable' => true
            ],
            [
                'position' => [
                    'lat' => 28.625293,
                    'lng' => 79.817926
                ],
                'label' => ['color' => 'white', 'text' => 'P2'],
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 28.625182,
                    'lng' => 79.81464
                ],
                'label' => ['color' => 'white', 'text' => 'P3'],
                'draggable' => true
            ]
        ];

        return view('userpage.evacuationCenter.evacuationCenter', ['evacuationCenter' => $evacuationCenter, 'initialMarkers' => $initialMarkers]);
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
