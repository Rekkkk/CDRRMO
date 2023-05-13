<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller{
    public function dashboard(){
        return view('/userpage/dashboard');
    }

    public function residentEligtasGuideline(){
        $guidelineList = new GuidelineController();
        $guidelineList = $guidelineList->guideline();

        return view('userpage.guideline.eligtasGuideline', $guidelineList);
    }

    public function residentEligtasGuide($guidelineId){
        $guidelineList = new GuidelineController();
        $guidelineList = $guidelineList->guide($guidelineId);

        return view('userpage.guideline.guide', $guidelineList);
    }

    public function residentEvacuationCenter(){
        $evacuationCenter = EvacuationCenter::all();

        return view('userpage.evacuationCenter.evacuationCenter', ['evacuationCenter' => $evacuationCenter]);
    }

    public function residentStatistics()
    {
        $typhoonMaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '1')->where('evacuee_gender', 'Male')->get();
        $typhoonFemaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '1')->where('evacuee_gender', 'Female')->get();
        $earthquakeMaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '2')->where('evacuee_gender', 'Male')->get();
        $earthquakeFemaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '2')->where('evacuee_gender', 'Female')->get();
        $roadAccidentMaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '3')->where('evacuee_gender', 'Male')->get();
        $roadAccidentFemaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '3')->where('evacuee_gender', 'Female')->get();
        $floodingMaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '4')->where('evacuee_gender', 'Male')->get();
        $floodingFemaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '4')->where('evacuee_gender', 'Female')->get();
        
        return view('userpage.statistics.statistics', compact('typhoonMaleData', 'typhoonFemaleData', 'earthquakeMaleData', 'earthquakeFemaleData', 'roadAccidentMaleData', 'roadAccidentFemaleData', 'floodingMaleData', 'floodingFemaleData'));
    }
    
    public function residentReportAccident(){
        return view('userpage.reportAccident.reportAccident');
    }

    public function residentHotlineNumber(){
        return view('userpage.hotlineNumbers.hotlineNumbers');
    }

    public function residentAbout(){
        return view('userpage.about.about');
    }
}