<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Evacuee;
use App\Models\Disaster;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use App\Models\EvacuationCenter;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class CswdController extends Controller
{
    private $evacuee;

    function __construct()
    {
        $this->evacuee = new Evacuee;
    }
    public function dashboard()
    {
        return view('userpage.dashboard');
    }

    public function recordEvacuee()
    {
        $evacuationCenters = EvacuationCenter::all();
        $disasters = Disaster::all();
        return view('userpage.recordEvacuee.recordEvacuee', compact('evacuationCenters', 'disasters'));
    }

    public function recordEvacueeInfo(Request $request)
    {
        $validatedEvacueeForm = Validator::make($request->all(), [
            'house_hold_number' => 'required',
            'name' => 'required',
            'sex' => 'required',
            'age' => 'required',
            'barangay' => 'required',
            'disaster' => 'required',
            'evacuation_assigned' => 'required'
        ]);

        if ($validatedEvacueeForm->passes()) {

            $is4Ps = $request->has('fourps') ? 1 : 0;
            $isPWD = $request->has('pwd') ? 1 : 0;
            $isPregnant = $request->has('pregnant') ? 1 : 0;
            $isLactating = $request->has('lactating') ? 1 : 0;
            $isStudent = $request->has('student') ? 1 : 0;
            $isWorking = $request->has('working') ? 1 : 0;

            $evacueeObject = [
                'house_hold_number' => $request->house_hold_number,
                'name' => Str::ucfirst(trim($request->name)),
                'sex' => $request->sex,
                'age' => $request->age,
                '4Ps' => $is4Ps,
                'PWD' => $isPWD,
                'pregnant' => $isPregnant,
                'lactating' => $isLactating,
                'student' => $isStudent,
                'working' => $isWorking,
                'barangay' => $request->barangay,
                'date_entry' => Carbon::now()->toDayDateTimeString(),
                'disaster_id' => $request->disaster,
                'evacuation_assigned' => $request->evacuation_assigned
            ];

            try {
                $this->evacuee->recordEvacueeObject($evacueeObject);

                ActivityUserLog::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Registering Evacuee',
                    'date_time' => Carbon::now()->toDayDateTimeString()
                ]);

                return response()->json(['condition' => 1]);
            } catch (\Exception $e) {
                return response()->json(['condition' => 0]);
            }
        }

        return response()->json(['condition' => 0, 'error' => $validatedEvacueeForm->errors()->toArray()]);
    }

    public function statistics()
    {
        $typhoonMaleData = Evacuee::select('sex')->where('disaster_id', '1')->where('sex', 'Male')->get();
        $typhoonFemaleData = Evacuee::select('sex')->where('disaster_id', '1')->where('sex', 'Female')->get();
        $earthquakeMaleData = Evacuee::select('sex')->where('disaster_id', '2')->where('sex', 'Male')->get();
        $earthquakeFemaleData = Evacuee::select('sex')->where('disaster_id', '2')->where('sex', 'Female')->get();
        $roadAccidentMaleData = Evacuee::select('sex')->where('disaster_id', '3')->where('sex', 'Male')->get();
        $roadAccidentFemaleData = Evacuee::select('sex')->where('disaster_id', '3')->where('sex', 'Female')->get();
        $floodingMaleData = Evacuee::select('sex')->where('disaster_id', '4')->where('sex', 'Male')->get();
        $floodingFemaleData = Evacuee::select('sex')->where('disaster_id', '4')->where('sex', 'Female')->get();

        return view('userpage.statistics.statistics', compact('typhoonMaleData', 'typhoonFemaleData', 'earthquakeMaleData', 'earthquakeFemaleData', 'roadAccidentMaleData', 'roadAccidentFemaleData', 'floodingMaleData', 'floodingFemaleData'));
    }
}
