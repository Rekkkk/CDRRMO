<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CswdController extends Controller
{

    public function dashboard()
    {
        return view('userpage.dashboard');
    }

    public function recordEvacuee()
    {
        $recordEvacueeController = new RecordEvacueeController();

        $barangays = $recordEvacueeController->barangayList();
        $evacuationCenters = $recordEvacueeController->evacuationCenterList();
        $disasters = $recordEvacueeController->disasterList();

        return view('userpage.recordEvacuee.recordEvacuee', compact('barangays', 'evacuationCenters', 'disasters'));
    }

    public function statistics()
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

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully Logout CSWD Panel');
    }
}
