<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Evacuee;
use App\Models\Barangay;
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
        $barangays = Barangay::all()->sortBy('barangay_name');
        $evacuationCenters = EvacuationCenter::all()->sortBy('evacuation_center_name');
        $disasters = Disaster::all()->sortBy('disaster_name');

        return view('userpage.recordEvacuee.recordEvacuee', compact('barangays', 'evacuationCenters', 'disasters'));
    }

    public function recordEvacueeInfo(Request $request)
    {
        $validatedEvacueeForm = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'middle_name' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'suffix' => 'required',
            'contact_number' => 'required|numeric|digits:11',
            'age' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'barangay' => 'required',
            'evacuation_center' => 'required',
            'disaster' => 'required'
        ]);

        if ($validatedEvacueeForm->passes()) {

            $evacueeObject = [
                'evacuee_first_name' => Str::ucfirst(trim($request->first_name)),
                'evacuee_middle_name' => Str::ucfirst(trim($request->middle_name)),
                'evacuee_last_name' => Str::ucfirst(trim($request->last_name)),
                'evacuee_suffix' => Str::ucfirst(trim($request->suffix)),
                'evacuee_contact_number' => trim($request->contact_number),
                'evacuee_age' => trim($request->age),
                'evacuee_gender' => trim($request->gender),
                'evacuee_address' => trim($request->address),
                'barangay_id' => $request->barangay,
                'disaster_id' => $request->disaster,
                'evacuation_assigned' => $request->evacuation_center
            ];

            try {
                $this->evacuee->recordEvacueeObject($evacueeObject);
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Record Evacuee Information');
            }

            $currentDate = Carbon::now();
            $todayDate = $currentDate->toDayDateTimeString();
    
            ActivityUserLog::create([
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'user_role' => Auth::user()->user_role,
                'role_name' => Auth::user()->role_name,
                'activity' => 'Logged Out',
                'date_time' => $todayDate,
            ]);
            
            Alert::success(config('app.name'), 'Evacuee Information Recorded Successfully');
            return response()->json(['condition' => 1]);
        }

        return response()->json(['condition' => 0, 'error' => $validatedEvacueeForm->errors()->toArray()]);
    }

    public function statistics()
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
}
