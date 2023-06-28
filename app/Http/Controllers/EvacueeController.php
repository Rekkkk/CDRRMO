<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Evacuee;
use Illuminate\Support\Str;
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

    public function loadEvacueeTable()
    {
        $data = $this->evacuee->all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button data-id="' . $row->id . '" data-toggle="modal" data-target="#evacueeInfoFormModal"' .
                    ' class="editEvacueeBtn updateEvacuationCenter"><i class="bi bi-pencil-square pr-2"></i>Edit</button>';
            })
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" class="w-4 h-4 accent-blue-600" value="' . $row->id . '">';
            })
            ->rawColumns(['select', 'action'])
            ->make(true);
    }

    public function recordEvacueeInfo(Request $request)
    {
        $validateFullName = Validator::make($request->all(), ['fullName' => 'required']);

        if (!$validateFullName->passes())
            return response()->json(['condition' => 0]);

        $disasterId = null;
        $is4Ps = $request->has('fourps') ? 1 : 0;
        $isPWD = $request->has('pwd') ? 1 : 0;
        $isPregnant = $request->has('pregnant') ? 1 : 0;
        $isLactating = $request->has('lactating') ? 1 : 0;
        $isStudent = $request->has('student') ? 1 : 0;
        $isWorking = $request->has('working') ? 1 : 0;
        $request->disasterType == "Typhoon" ?
            $disasterId = $request->typhoon :
            $disasterId = $request->flashflood;

        $evacueeInfo = [
            'house_hold_number' => $request->houseHoldNumber,
            'full_name' => Str::ucfirst(trim($request->fullName)),
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
            'disaster_type' => $request->disasterType,
            'disaster_id' => intval($disasterId),
            'disaster_info' => $request->disasterInfo,
            'evacuation_assigned' => $request->evacuationAssigned
        ];

        $this->evacuee->create($evacueeInfo);
        $this->logActivity->generateLog('Recorded new evacuee information');

        return response()->json(['condition' => 1]);
    }

    public function updateEvacueeInfo($evacueeId, Request $request)
    {
        $validateFullName = Validator::make($request->all(), ['fullName' => 'required']);

        if (!$validateFullName->passes())
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
            '4Ps' => $is4Ps,
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

    public function updateEvacueeDateOut(Request $request)
    {
        $evacueeIds = $request->evacueeIds;
        $dateOut = Carbon::now()->toDayDateTimeString();

        foreach ($evacueeIds as $evacueeId)
            $this->evacuee->find(intval($evacueeId))->update(['date_out' => $dateOut]);

        $this->logActivity->generateLog('Updated evacuee/s date out');

        return response()->json();
    }
}
