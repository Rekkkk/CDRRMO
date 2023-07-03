<?php

namespace App\Http\Controllers;

use App\Models\Typhoon;
use App\Models\Evacuee;
use App\Models\Disaster;
use App\Models\Flashflood;
use Illuminate\Http\Request;
use App\Models\EvacuationCenter;

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

        $typhoonMaleData = $evacuee->countEvacuee(1, 'Male');
        $typhoonFemaleData = $evacuee->countEvacuee(1, 'Female');
        $floodingMaleData = $evacuee->countEvacuee(2, 'Male');
        $floodingFemaleData = $evacuee->countEvacuee(2, 'Female');

        $typhoonData = $evacuee->countEvacueeWithDisablities(1);

        $typhoon_4Ps = intval($typhoonData[0]->{'4Ps'});
        $typhoon_PWD = intval($typhoonData[0]->PWD);
        $typhoon_pregnant = intval($typhoonData[0]->pregnant);
        $typhoon_lactating = intval($typhoonData[0]->lactating);
        $typhoon_student = intval($typhoonData[0]->student);
        $typhoon_working = intval($typhoonData[0]->working);

        $floodingData = $evacuee->countEvacueeWithDisablities(2);

        $flooding_4Ps = intval($floodingData[0]->{'4Ps'});
        $flooding_PWD = intval($floodingData[0]->PWD);
        $flooding_pregnant = intval($floodingData[0]->pregnant);
        $flooding_lactating = intval($floodingData[0]->lactating);
        $flooding_student = intval($floodingData[0]->student);
        $flooding_working = intval($floodingData[0]->working);

        return view('userpage.dashboard', compact(
            'activeEvacuation',
            'inActiveEvacuation',
            'inEvacuationCenter',
            'isReturned',
            'typhoonMaleData',
            'typhoonFemaleData',
            'floodingMaleData',
            'floodingFemaleData',
            'typhoon_4Ps',
            'typhoon_PWD',
            'typhoon_pregnant',
            'typhoon_lactating',
            'typhoon_student',
            'typhoon_working',
            'flooding_4Ps',
            'flooding_PWD',
            'flooding_pregnant',
            'flooding_lactating',
            'flooding_student',
            'flooding_working'
        ));
    }

    public function manageEvacueeInformation(Request $request)
    {
        $disaster = new Disaster;

        $evacuationList = $this->evacuationCenter->all();
        $typhoonList =  Typhoon::all();
        $flashfloodList = Flashflood::all()->where('status', 'Rising');
        $disasterList = null;

        if($typhoonList->isNotEmpty() && $flashfloodList->isNotEmpty()){
            $disasterList = $disaster->all();
        }else if($typhoonList->isNotEmpty()){
            $disasterList = $disaster->where('id', 1)->get();
        }else if($flashfloodList->isNotEmpty()){
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
