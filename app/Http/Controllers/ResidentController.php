<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;
use App\Models\Evacuee;
use App\Models\Guide;
use App\Models\Quiz;
use Illuminate\Support\Facades\Crypt;

class ResidentController extends Controller
{
    private $guideline;

    public function dashboard()
    {
        return view('/userpage/dashboard');
    }

    public function residentEligtasGuideline()
    {
        $guideline = $this->guideline->displayGuideline();

        return view('userpage.guideline.eligtasGuideline', compact('guideline'));
    }

    public function residentEligtasGuide($guidelineId)
    {
        $guide = Guide::where('guideline_id', Crypt::decryptString($guidelineId))->orderBy('guide_id', 'asc')->get();

        $quiz = Quiz::where('guideline_id', $guidelineId)->get();

        return view('userpage.guideline.guide', compact('guide', 'quiz'))->with('guidelineId', $guidelineId);
    }

    public function residentEvacuationCenter()
    {
        $evacuationCenter = EvacuationCenter::all();

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

    public function residentStatistics()
    {
        $typhoonMaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '1')->where('evacuee_gender', 'Male')->get();
        $typhoonFemaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '1')->where('evacuee_gender', 'Female')->get();
        $earthquakeMaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '2')->where('evacuee_gender', 'Male')->get();
        $earthquakeFemaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '2')->where('evacuee_gender', 'Female')->get();
        $roadAccidentMaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '3')->where('evacuee_gender', 'Male')->get();
        $roadAccidentFemaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '3')->where('evacuee_gender', 'Female')->get();
        $floodingMaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '4')->where('evacuee_gender', 'Male')->get();
        $floodingFemaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '4')->where('evacuee_gender', 'Female')->get();

        return view('userpage.statistics.statistics', compact('typhoonMaleData', 'typhoonFemaleData', 'earthquakeMaleData', 'earthquakeFemaleData', 'roadAccidentMaleData', 'roadAccidentFemaleData', 'floodingMaleData', 'floodingFemaleData'));
    }

    public function residentReportAccident()
    {
        return view('userpage.reportAccident.reportAccident');
    }

    public function residentHotlineNumber()
    {
        return view('userpage.hotlineNumbers.hotlineNumbers');
    }

    public function residentAbout()
    {
        return view('userpage.about.about');
    }
}
