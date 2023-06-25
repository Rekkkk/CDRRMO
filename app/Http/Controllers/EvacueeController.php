<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Evacuee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;

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
        $data = Evacuee::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button data-id="' . $row->id . '" data-toggle="modal" data-target="#evacueeInfoFormModal" class="editEvacueeBtn bg-yellow-500 w-20 text-sm font-semibold hover:bg-yellow-600 py-1.5 btn-sm mr-2 text-white updateEvacuationCenter"><i class="bi bi-pencil-square pr-2"></i>Edit</button>';
            })
            ->addColumn('select', function ($row) {
                return '<input type="checkbox" class="w-4 h-4 accent-blue-600" value="' . $row->id . '">';
            })
            ->rawColumns(['select', 'action'])
            ->make(true);
    }

    public function recordEvacueeInfo(Request $request)
    {
        $validatedEvacueeForm = Validator::make($request->all(), [
            'fullName' => 'required',
        ]);
        if ($validatedEvacueeForm->passes()) {
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
            try {
                $this->evacuee->recordEvacueeObject($evacueeInfo);
                $this->logActivity->generateLog('Recorded new evacuee information');
                return response()->json(['condition' => 1]);
            } catch (\Exception $e) {
                return response()->json(['condition' => 0]);
            }
        }
        return response()->json(['condition' => 0]);
    }

    public function updateEvacueeInfo($evacueeId, Request $request)
    {
        $validatedEvacueeForm = Validator::make($request->all(), [
            'fullName' => 'required',
        ]);
        if ($validatedEvacueeForm->passes()) {
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
                'date_entry' => $request->dateEntry,
                'date_out' => $request->dateOut,
                'disaster_type' => $request->disasterType,
                'disaster_id' => intval($disasterId),
                'disaster_info' => $request->disasterInfo,
                'evacuation_assigned' => $request->evacuationAssigned
            ];
            try {
                $this->evacuee->updateEvacueeInfo($evacueeId, $evacueeInfo);
                $this->logActivity->generateLog('Updated an evacuee information');
                return response()->json(['condition' => 1]);
            } catch (\Exception $e) {
                return response()->json(['condition' => 0]);
            }
        }
        return response()->json(['condition' => 0]);
    }

    public function updateEvacueeDateOut(Request $request)
    {
        $evacueeIds = $request->evacueeIds;
        foreach ($evacueeIds as $evacueeId)
            $this->evacuee->updateEvacueeDateOut(intval($evacueeId), ['date_out' => Carbon::now()->toDayDateTimeString()]);
        $this->logActivity->generateLog('Updated evacuee/s date out');
        return response()->json();
    }
}
