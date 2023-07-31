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
                return '<button class="btn-table-update p-2" id="updateEvacueeBtn"><i class="bi bi-pencil-square pr-2"></i>Update</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function recordEvacueeInfo(Request $request)
    {
        $evacueeInfoValidation = Validator::make($request->all(), [
            'infants' => 'required|numeric',
            'minors' => 'required|numeric',
            'senior_citizen' => 'required|numeric',
            'pwd' => 'required|numeric',
            'pregnant' => 'required|numeric',
            'lactating' => 'required|numeric',
            'families' => 'required|numeric',
            'individuals' => 'required|numeric',
            'male' => 'required|numeric',
            'female' => 'required|numeric',
            'disaster_id' => 'required',
            'date_entry' => 'required',
            'barangay' => 'required|unique:evacuee,barangay',
            'evacuation_assigned' => 'required'
        ]);

        if ($evacueeInfoValidation->passes()) {
            $evacueeInfo = $request->only([
                'infants', 'minors', 'senior_citizen', 'pwd', 'pregnant', 'lactating',
                'families', 'individuals', 'male', 'female', 'disaster_id', 'date_entry',
                'barangay', 'evacuation_assigned'
            ]);
            $evacueeInfo['remarks'] = Str::ucfirst(trim($request->remarks));
            $this->evacuee->create($evacueeInfo);
            $this->logActivity->generateLog('Recording evacuee information');
            // event(new ActiveEvacuees());

            return response()->json();
        }

        return response(['status' => 'warning', 'message' => $evacueeInfoValidation->errors()->first()]);
    }

    public function updateEvacueeInfo(Request $request, $evacueeId)
    {
        $evacueeInfoValidation = Validator::make($request->all(), [
            'infants' => 'required|numeric',
            'minors' => 'required|numeric',
            'senior_citizen' => 'required|numeric',
            'pwd' => 'required|numeric',
            'pregnant' => 'required|numeric',
            'lactating' => 'required|numeric',
            'families' => 'required|numeric',
            'individuals' => 'required|numeric',
            'male' => 'required|numeric',
            'female' => 'required|numeric',
            'disaster_id' => 'required',
            'date_entry' => 'required',
            'barangay' => 'required|unique:evacuee,barangay',
            'evacuation_assigned' => 'required'
        ]);

        if ($evacueeInfoValidation->passes()) {
            $evacueeInfo = $request->only([
                'infants', 'minors', 'senior_citizen', 'pwd', 'pregnant', 'lactating',
                'families', 'individuals', 'male', 'female', 'disaster_id', 'date_entry',
                'barangay', 'evacuation_assigned'
            ]);
            $evacueeInfo['remarks'] = Str::ucfirst(trim($request->remarks));
            $this->evacuee->find($evacueeId)->update($evacueeInfo);
            $this->logActivity->generateLog('Updating an evacuee information');

            return response()->json();
        }

        return response(['status' => 'warning', 'message' => $evacueeInfoValidation->errors()->first()]);
    }
}
