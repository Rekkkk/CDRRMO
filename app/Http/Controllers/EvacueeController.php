<?php

namespace App\Http\Controllers;


use App\Models\Evacuee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\ActiveEvacuees;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class EvacueeController extends Controller
{
    private $evacuee, $logActivity;

    function __construct()
    {
        $this->evacuee = new Evacuee;
        $this->logActivity = new ActivityUserLog;
    }

    public function getEvacueeData()
    {
        $evacueeInfo = $this->evacuee->all();
        return DataTables::of($evacueeInfo)
            ->addIndexColumn()
            ->addColumn('action', function () {
                return '<button class="btn-table-update p-2 updateEvacueeBtn"><i class="bi bi-pencil-square pr-2"></i>Update</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function recordEvacueeInfo(Request $request)
    {
        $evacueeInfoValidation = Validator::make($request->all(), [
            'infants' => 'required',
            'minors' => 'required',
            'senior_citizen' => 'required',
            'pwd' => 'required',
            'pregnant' => 'required',
            'lactating' => 'required',
            'families' => 'required',
            'individual' => 'required',
            'male' => 'required',
            'female' => 'required',
            'disaster_id' => 'required',
            'date_entry' => 'required',
            'barangay' => 'required|unique:evacuee,barangay',
            'evacuation_assigned' => 'required'
        ]);

        if ($evacueeInfoValidation->passes()) {
            $this->evacuee->create([
                'infants' => $request->infants,
                'minors' => $request->minors,
                'senior_citizen' => $request->senior_citizen,
                'pwd' => $request->pwd,
                'pregnant' => $request->pregnant,
                'lactating' => $request->lactating,
                'families' => $request->families,
                'individuals' => $request->individual,
                'male' => $request->male,
                'female' => $request->female,
                'disaster_id' => $request->disaster_id,
                'date_entry' => $request->date_entry,
                'barangay' => $request->barangay,
                'evacuation_assigned' => $request->evacuation_assigned,
                'remarks' => trim($request->remarks)
            ]);

            // event(new ActiveEvacuees());

            $this->logActivity->generateLog('Recording evacuee information');

            return response()->json();
        }

        return response(['status' => "warning", 'message' => $evacueeInfoValidation->errors()->first()]);
    }

    public function updateEvacueeInfo($evacueeId, Request $request)
    {
        $validateEvacuee = Validator::make($request->all(), [
            'houseHoldNumber' => 'required',
            'fullName' => 'required',
            'sex' => 'required',
            'age' => 'required',
            'dateEntry' => 'required',
            'dateOut' => 'required',
            'barangay' => 'required',
            'disasterType' => 'required',
            'typhoon' => 'required',
            'flashflood' => 'required',
            'evacuationAssigned' => 'required'
        ]);

        if (!$validateEvacuee->passes())
            return response()->json(['condition' => 0]);

        $disasterId = $evacuationAssigned = null;
        $is4Ps = $request->has('fourps') ? 1 : 0;
        $isPWD = $request->has('pwd') ? 1 : 0;
        $isPregnant = $request->has('pregnant') ? 1 : 0;
        $isLactating = $request->has('lactating') ? 1 : 0;
        $isStudent = $request->has('student') ? 1 : 0;
        $isWorking = $request->has('working') ? 1 : 0;

        $request->disasterType == "Typhoon" ?
            $disasterId = $request->typhoon :
            $disasterId = $request->flashflood;

        filled($request->evacuationAssigned) ?
            $evacuationAssigned = $request->evacuationAssigned :
            $evacuationAssigned = $request->defaultEvacuationAssigned;

        $evacueeInfo = [
            'house_hold_number' => $request->houseHoldNumber,
            'full_name' => Str::ucfirst(trim($request->fullName)),
            'sex' => $request->sex,
            'age' => $request->age,
            'fourps' => $is4Ps,
            'PWD' => $isPWD,
            'pregnant' => $isPregnant,
            'lactating' => $isLactating,
            'student' => $isStudent,
            'working' => $isWorking,
            'barangay' => $request->barangay,
            'date_entry' => $request->dateEntry,
            'date_out',
            'disaster_type' => $request->disasterType,
            'disaster_id' => intval($disasterId),
            'disaster_info' => $request->disasterInfo,
            'evacuation_assigned' => $evacuationAssigned
        ];

        if (filled($request->dateOut))
            $evacueeInfo['date_out'] = $request->dateOut;

        $this->evacuee->find($evacueeId)->update($evacueeInfo);
        $this->logActivity->generateLog('Updated an evacuee information');

        return response()->json(['condition' => 1]);
    }
}
