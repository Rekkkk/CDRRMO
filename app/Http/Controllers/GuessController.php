<?php

namespace App\Http\Controllers;

class GuessController extends Controller
{
    public function dashboard(){
        return view('/CDRRMO/dashboard');
    }

    public function guessEligtasGuidelines(){
        $guidelinesList = new GuidelinesController();
        $guidelinesList = $guidelinesList->guidelines();

        return view('CDRRMO.guidelines.eligtasGuidelines', $guidelinesList);
    }

    public function guessEvacuationCenter(){
        return view('CDRRMO.evacuation.evacuationCenter');
    }

    public function guessReportAccident(){
        return view('CDRRMO.report.reportAccident');
    }

    public function guessHotlineNumbers(){
        return view('CDRRMO.hotlineNumbers.hotlineNumbers');
    }

    public function guessAbout(){
        return view('CDRRMO.about.about');
    }
}
