<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;

class GuestController extends Controller{
    public function dashboard(){
        return view('/cdrrmo/dashboard');
    }

    public function guestEligtasGuideline(){
        $guidelineList = new GuidelineController();
        $guidelineList = $guidelineList->guideline();

        return view('cdrrmo.guideline.eligtasGuideline', $guidelineList);
    }

    public function guestEligtasGuide($guidelineId){
        $guidelineList = new GuidelineController();
        $guidelineList = $guidelineList->guide($guidelineId);

        return view('cdrrmo.guideline.guide', $guidelineList);
    }

    public function guestEvacuationCenter(){
        $evacuationCenter = EvacuationCenter::all();

        return view('cdrrmo.evacuationCenter.evacuationCenter', ['evacuationCenter' => $evacuationCenter]);
    }

    public function guestReportAccident(){
        return view('cdrrmo.reportAccident.reportAccident');
    }

    public function guestHotlineNumber(){
        return view('cdrrmo.hotlineNumbers.hotlineNumbers');
    }

    public function guestAbout(){
        return view('cdrrmo.about.about');
    }
}