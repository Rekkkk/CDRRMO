<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CdrrmoController extends Controller
{
    public function dashboard(){
        $this->middleware('ensure.token');

        return view('CDRRMO.dashboard');
    }

    public function recordEvacuee(){
        $recordEvacueeController = new RecordEvacueeController();

        $baranggayList = $recordEvacueeController->baranggayList();
        $evacuationCenterList = $recordEvacueeController->evacuationCenterList();
        $disasterList = $recordEvacueeController->disasterList();

        return view('CDRRMO.recordEvacuee.recordEvacuee', $baranggayList, $disasterList, $evacuationCenterList);
    }

    public function eligtasGuidelines(){
        $guidelinesList = new GuidelinesController();
        $guidelinesList = $guidelinesList->guidelines();

        return view('CDRRMO.guidelines.eligtasGuidelines', $guidelinesList);
    }

    public function eligtasGuide(){
        $guideList = new GuidelinesController();
        $guideList = $guideList->guide();

        return view('CDRRMO.guidelines.guide' , $guideList);
    }

    public function disaster(){
        $disasterList = new DisasterController();
        $disasterList = $disasterList->disasterList();

        return view('CDRRMO.disaster.disaster', $disasterList);
    }

    public function baranggay(){
        $baranggayList = new BaranggayController();
        $baranggayList = $baranggayList->baranggayList();

        return view('CDRRMO.baranggay.baranggay', $baranggayList);
    }

    public function evacuationManage(){
        $evacuation = new EvacuationCenterController();
        $evacuation = $evacuation->evacuationCenterList();

        return view('CDRRMO.evacuation.evacuation', $evacuation);
    }

    public function evacuationCenter(){

        $initialMarkers = [
            [
                'position' => [
                    'lat' => 28.625485,
                    'lng' => 79.821091
                ],
                'label' => [ 'color' => 'white', 'text' => 'P1' ],
                'draggable' => true
            ],
            [
                'position' => [
                    'lat' => 28.625293,
                    'lng' => 79.817926
                ],
                'label' => [ 'color' => 'white', 'text' => 'P2' ],
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 28.625182,
                    'lng' => 79.81464
                ],
                'label' => [ 'color' => 'white', 'text' => 'P3' ],
                'draggable' => true
            ]
        ];

        return view('CDRRMO.evacuation.evacuationCenter', compact('initialMarkers'));
    }

    public function statistics(){
        return view('CDRRMO.statistics.statistics');
    }

    public function reportAccident(){
        return view('CDRRMO.report.reportAccident');
    }

    public function hotlineNumbers(){
        return view('CDRRMO.hotlineNumbers.hotlineNumbers');
    }

    public function about(){
        return view('CDRRMO.about.about');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully Logout Admin Panel');
    }
}
