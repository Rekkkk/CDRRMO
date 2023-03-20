<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\AnnouncementController;

class CdrrmoController extends Controller
{
    public function dashboard(){
        $this->middleware('ensure.token');

        $cdrrmoAnnouncement = new AnnouncementController();
        $cdrrmoAnnouncement = $cdrrmoAnnouncement->displayAnnouncement();

        return view('CDRRMO.dashboard', ['announcements' => $cdrrmoAnnouncement]);
    }

    public function addData(){
        // Alert::success('Data Successfully Added!', 'Cabuyao City Disaster Risk Reduction Management Office');
        
        return view('CDRRMO.addData');
    }

    public function eligtasGuidelines(){
        return view('CDRRMO.eligtasGuidelines');
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
        $male = DB::table('typhoon')->pluck('male');
        $female = DB::table('typhoon')->pluck('female');

        return view('CDRRMO.statistics', compact('male', 'female'));
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
