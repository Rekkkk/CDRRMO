<?php

namespace App\Http\Controllers;

use App\Models\ActivityUserLog;
use App\Models\Disaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DisasterController extends Controller
{
    private $disaster;

    function __construct()
    {
        $this->disaster = new Disaster;
    }

    // public function registerDisaster(DisasterRequest $request){

    //     $disasterData = [
    //         'disaster_type' => Str::of(trim($request->disaster_type))->title(),
    //     ];

    //     try{
    //         $this->disaster->registerDisasterObject($disasterData);
    //         Alert::success('Disaster Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
    //     }catch(\Exception $e){
    //         Alert::error('Failed to Register Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
    //     }

    //     return back();
    // }

    public function getDisasterDetails($id)
    {
        if (request()->ajax()) {
            $data = Disaster::find($id);
            return response()->json(['result' => $data]);
        }
    }

    public function updateDisaster(Request $request, $disasterId)
    {
        $validatedDisaster = Validator::make($request->all(), [
            'disaster_type' => 'required',
        ]);

        if ($validatedDisaster->passes()) {

            $disasterData = [
                'disaster_type' => Str::ucfirst(trim($request->input('disaster_type')))
            ];

            try {
                $this->disaster->updateDisasterObject($disasterData, $disasterId);
                $currentDate = Carbon::now();
                $todayDate = $currentDate->toDayDateTimeString();

                ActivityUserLog::create([
                    'user_id' => Auth::user()->id,
                    'email' => Auth::user()->email,
                    'user_role' => Auth::user()->user_role,
                    'role_name' => Auth::user()->role_name,
                    'activity' => 'Updating Disaster Information',
                    'date_time' => $todayDate,
                ]);

                Alert::success(config('app.name'), 'Disaster Updated Successfully.');
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Update Disaster.');
            }

            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0, 'error' => $validatedDisaster->errors()->toArray()]);
    }

    public function removeDisaster($disasterId)
    {
        try {
            $this->disaster->removeDisasterObject($disasterId);
            $currentDate = Carbon::now();
            $todayDate = $currentDate->toDayDateTimeString();

            ActivityUserLog::create([
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'user_role' => Auth::user()->user_role,
                'role_name' => Auth::user()->role_name,
                'activity' => 'Deleting Disaster Information',
                'date_time' => $todayDate,
            ]);
            Alert::success(config('app.name'), 'Disaster Deleted Successfully.');
        } catch (\Exception $e) {
            Alert::error(config('app.name'), 'Failed to Deleted Disaster.');
        }



        return response()->json();
    }
}
