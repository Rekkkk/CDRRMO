<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Models\EvacuationCenter;

class EvacuationCenterController extends Controller
{
    private $evacuationCenter, $logActivity;

    function __construct()
    {
        $this->logActivity = new ActivityUserLog;
        $this->evacuationCenter = new EvacuationCenter;
    }

    public function getEvacuationData()
    {
        $evacuationCenterList = $this->evacuationCenter->all();

        return DataTables::of($evacuationCenterList)
            ->addIndexColumn()
            ->addColumn('action', function () {
                return '<div class="flex justify-around actionContainer"><button class="btn-table-edit updateEvacuationCenter"><i class="bi bi-pencil-square pr-2"></i>Edit</button>' .
                    '<button class="btn-table-remove removeEvacuationCenter"><i class="bi bi-trash3-fill pr-2"></i>Remove</button>' .
                    '<select class="form-select w-44 bg-blue-500 text-white changeEvacuationStatus">
                        <option value="">Change Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Full">Full</option>
                    </select></div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function addEvacuationCenter(Request $request)
    {
        $validateEvacuationCenter = Validator::make($request->all(), [
            'name' => 'required',
            'barangayName' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if (!$validateEvacuationCenter->passes()) {
            return response()->json(['condition' => 0]);
        }

        $this->evacuationCenter->create([
            'name' => Str::ucfirst($request->name),
            'barangay_name' => $request->barangayName,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'Active'
        ]);

        $this->logActivity->generateLog('Added new evacuation center');

        return response()->json(['condition' => 1]);
    }

    public function updateEvacuationCenter(Request $request, $evacuationId)
    {
        $validateEvacuationCenter = Validator::make($request->all(), [
            'name' => 'required',
            'barangayName' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if (!$validateEvacuationCenter->passes()) {
            return response()->json(['condition' => 0]);
        }

        $this->evacuationCenter->find($evacuationId)->update([
            'name' => Str::ucfirst(trim($request->name)),
            'barangay_name' => $request->barangayName,
            'latitude' => trim($request->latitude),
            'longitude' => trim($request->longitude),
        ]);

        $this->logActivity->generateLog('Updated evacuation center');

        return response()->json(['condition' => 1]);
    }

    public function removeEvacuationCenter($evacuationId)
    {
        $this->evacuationCenter->find($evacuationId)->delete();

        $this->logActivity->generateLog('Removed evacuation center');

        return response()->json();
    }

    public function changeEvacuationStatus($evacuationId, Request $request)
    {
        $this->evacuationCenter->find($evacuationId)->update([
            'status' => $request->status
        ]);

        $this->logActivity->generateLog('Changed evacuation center status');

        return response()->json();
    }
}
