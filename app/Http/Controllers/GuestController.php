<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;

class GuestController extends Controller{
    public function dashboard(){
        return view('/CDRRMO/dashboard');
    }

    public function guestEligtasGuideline(){
        $guidelineList = new GuidelineController();
        $guidelineList = $guidelineList->guideline();

        return view('CDRRMO.guideline.eligtasGuideline', $guidelineList);
    }

    public function guestEligtasGuide($guidelineId){
        $guidelineList = new GuidelineController();
        $guidelineList = $guidelineList->guide($guidelineId);

        return view('CDRRMO.guideline.guide', $guidelineList);
    }

    public function guestEvacuationCenter(){
        $evacuationCenter = EvacuationCenter::all();

        return view('CDRRMO.evacuationCenter.evacuationCenter', ['evacuationCenter' => $evacuationCenter]);
    }

    public function guestReportAccident(){
        return view('CDRRMO.report.reportAccident');
    }

    public function guestHotlineNumber(){
        return view('CDRRMO.hotlineNumbers.hotlineNumbers');
    }

    public function guestAbout(){
        return view('CDRRMO.about.about');
    }
}