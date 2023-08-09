<?php

namespace App\Http\Controllers;

use App\Models\Evacuee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use App\Models\EvacuationCenter;
use Illuminate\Support\Facades\Validator;

class EvacuationCenterController extends Controller
{
    private $evacuationCenter, $logActivity;

    function __construct()
    {
        $this->logActivity = new ActivityUserLog;
        $this->evacuationCenter = new EvacuationCenter;
    }

    public function getEvacuationData($operation)
    {
        $evacuationCenterList = $this->evacuationCenter->orderBy('name', 'asc')->get();

        return DataTables::of($evacuationCenterList)
            ->addIndexColumn()
            ->addColumn('capacity', function ($row) use ($operation) {
                return $operation == "locator" ? Evacuee::where('evacuation_assigned', $row->name)->sum('individuals') . '/' . $row->capacity : $row->capacity;
            })->addColumn('action', function ($row) use ($operation) {
                if ($operation == "locator")
                    return '<button class="btn-table-primary text-white locateEvacuationCenter"><i class="bi bi-search"></i>Locate</button>';

                if (auth()->user()->is_disable == 0) {
                    $statusOptions = implode('', array_map(function ($status) use ($row) {
                        return $row->status != $status ? '<option value="' . $status . '">' . $status . '</option>' : '';
                    }, ['Active', 'Inactive', 'Full']));

                    return '<div class="action-container">' .
                        '<button class="btn-table-update updateEvacuationCenter"><i class="bi bi-pencil-square"></i>Update</button>' .
                        '<button class="btn-table-remove removeEvacuationCenter"><i class="bi bi-trash3-fill"></i>Remove</button>' .
                        '<select class="form-select changeEvacuationStatus">' .
                        '<option value="" disabled selected hidden>Change Status</option>' .
                        $statusOptions . '</select></div>';
                }

                return '<span class="message-text">Currently Disabled.</span>';
            })
            ->rawColumns(['capacity', 'action'])
            ->make(true);
    }

    public function createEvacuationCenter(Request $request)
    {
        $validateEvacuationCenter = Validator::make($request->all(), [
            'name' => 'required',
            'barangayName' => 'required',
            'capacity' => 'required|numeric|min:1',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if ($validateEvacuationCenter->fails())
            return response(['status' => 'warning', 'message' => implode('<br>', $validateEvacuationCenter->errors()->all())]);

        $this->evacuationCenter->create([
            'name' => Str::ucfirst(trim($request->name)),
            'barangay_name' => $request->barangayName,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'capacity' => trim($request->capacity),
            'status' => 'Active'
        ]);
        $this->logActivity->generateLog('Adding new evacuation center');
        return response()->json();
    }

    public function updateEvacuationCenter(Request $request, $evacuationId)
    {
        $validateEvacuationCenter = Validator::make($request->all(), [
            'name' => 'required',
            'barangayName' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if ($validateEvacuationCenter->fails())
            return response(['status' => 'warning', 'message' => $validateEvacuationCenter->errors()->first()]);

        $this->evacuationCenter->find($evacuationId)->update([
            'name' => Str::ucfirst(trim($request->name)),
            'barangay_name' => $request->barangayName,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'capacity' => trim($request->capacity)
        ]);
        $this->logActivity->generateLog('Updating evacuation center');
        return response()->json();
    }

    public function removeEvacuationCenter($evacuationId)
    {
        $this->evacuationCenter->find($evacuationId)->delete();
        $this->logActivity->generateLog('Removing evacuation center');
        return response()->json();
    }

    public function changeEvacuationStatus(Request $request, $evacuationId)
    {
        $this->evacuationCenter->find($evacuationId)->update([
            'status' => $request->status
        ]);
        $this->logActivity->generateLog('Changing evacuation center status');
        return response()->json();
    }
}
