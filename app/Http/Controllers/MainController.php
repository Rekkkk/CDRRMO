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
        $typhoonData = $evacuee->countEvacueeWithDisabilities('Typhoon')->first();
        $floodingData = $evacuee->countEvacueeWithDisabilities('Flashflood')->first();

        $statisticData = compact(
            'activeEvacuation',
            'inActiveEvacuation',
            'inEvacuationCenter',
            'isReturned'
        );

        if ($typhoonData) {
            $typhoonData = $typhoonData->toArray();
            $statisticData['typhoon4Ps'] = intval($typhoonData['fourps']);
            $statisticData['typhoonPWD'] = intval($typhoonData['PWD']);
            $statisticData['typhoonPregnant'] = intval($typhoonData['pregnant']);
            $statisticData['typhoonLactating'] = intval($typhoonData['lactating']);
            $statisticData['typhoonStudent'] = intval($typhoonData['student']);
            $statisticData['typhoonWorking'] = intval($typhoonData['working']);
        }

        if ($floodingData) {
            $floodingData = $floodingData->toArray();
            $statisticData['flooding4Ps'] = intval($floodingData['fourps']);
            $statisticData['floodingPWD'] = intval($floodingData['PWD']);
            $statisticData['floodingPregnant'] = intval($floodingData['pregnant']);
            $statisticData['floodingLactating'] = intval($floodingData['lactating']);
            $statisticData['floodingStudent'] = intval($floodingData['student']);
            $statisticData['floodingWorking'] = intval($floodingData['working']);
        }

        $statisticData['typhoonMaleData'] = $evacuee->countEvacuee('Typhoon', 'Male');
        $statisticData['typhoonFemaleData'] = $evacuee->countEvacuee('Typhoon', 'Female');
        $statisticData['flashfloodMaleData'] = $evacuee->countEvacuee('Flashflood', 'Male');
        $statisticData['flashfloodFemaleData'] = $evacuee->countEvacuee('Flashflood', 'Female');

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

    public function evacuationCenter()
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

    public function evacuationManage()
    {
        return view('userpage.evacuationCenter.evacuation');
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
