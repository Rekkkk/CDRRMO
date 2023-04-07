<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CdrrmoController extends Controller
{
    public function dashboard(){
        $this->middleware('ensure.token');

        return view('CDRRMO.dashboard');
    }

    public function addData(){
        // Alert::success('Data Successfully Added!', 'Cabuyao City Disaster Risk Reduction Management Office');
        
        return view('CDRRMO.addData');
    }

    public function disaster(){
        $disasterList = new DisasterController();
        $disasterList = $disasterList->disasterList();

        return view('CDRRMO.disaster.disaster', $disasterList);
    }

    public function eligtasGuidelines(){
        return view('CDRRMO.guidelines.eligtasGuidelines');
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

        return view('CDRRMO.evacuationCenter', compact('initialMarkers'));
    }

    public function hotlineNumbers(){
        return view('CDRRMO.hotlineNumbers');
    }

    public function statistics(){
        // $male = DB::table('typhoon')->pluck('male');
        // $female = DB::table('typhoon')->pluck('female');

        //, compact('male', 'female')
        return view('CDRRMO.statistics');
    }

    public function reportAccident(){
        return view('CDRRMO.reportAccident');
    }

    public function about(){
        return view('CDRRMO.about');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully Logout Admin Panel');
    }
}
