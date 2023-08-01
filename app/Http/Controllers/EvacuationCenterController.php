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
        $evacuationCenterList = $this->evacuationCenter->orderBy('name', 'asc')->where('is_archive', 0)->get();

        return DataTables::of($evacuationCenterList)
            ->addIndexColumn()
            ->addColumn('capacity', function ($row) use ($operation) {
                return $operation == "locator" ? Evacuee::where('evacuation_assigned', $row->name)->sum('individuals') . '/' . $row->capacity : $row->capacity;
            })
            ->addColumn('status', function ($row) {
                $color = match ($row->status) {
                    'Active' => 'green',
                    'Inactive' => 'red',
                    'Full' => 'orange'
                };

                return '<div class="flex justify-center"><div class="bg-' . $color . '-600 status-container">' . $row->status . '</div></div>';
            })->addColumn('action', function ($row) use ($operation) {
                if ($operation == "locator") {
                    return $row->status == 'Inactive' ? "<span class='text-sm'>Evacuation Center isn't available.</span>" :
                        '<button class="btn-table-primary p-2 w-24 text-white locateEvacuationCenter"><i class="bi bi-search pr-2"></i>Locate</button>';
                } else {
                    if (auth()->user()->is_disable == 0) {
                        $statusOptions = '';
                        $availableStatus = ['Active', 'Inactive', 'Full'];

                        foreach ($availableStatus as $status) {
                            if ($row->status != $status) 
                                $statusOptions .= '<option value="' . $status . '">' . $status . '</option>';
                        }

                        return '<div class="flex justify-center actionContainer">' .
                            '<button class="btn-table-update w-28 mr-2 updateEvacuationCenter"><i class="bi bi-pencil-square pr-2"></i>Update</button>' .
                            '<button class="btn-table-remove w-28 mr-2 removeEvacuationCenter"><i class="bi bi-trash3-fill pr-2"></i>Remove</button>' .
                            '<select class="form-select w-44 bg-blue-500 text-white drop-shadow-md changeEvacuationStatus">' .
                            '<option value="" disabled selected hidden>Change Status</option>' .
                            $statusOptions . '</select></div>';
                    }

                    return '<span class="text-sm">Currently Disabled.</span>';
                }
            })
            ->rawColumns(['capacity', 'status', 'action'])
            ->make(true);
    }

    public function createEvacuationCenter(Request $request)
    {
        $validateEvacuationCenter = Validator::make($request->all(), [
            'name' => 'required',
            'barangayName' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if ($validateEvacuationCenter->fails())
            return response(['status' => 'warning', 'message' => $validateEvacuationCenter->errors()->first()]);

        $this->evacuationCenter->create([
            'name' => Str::ucfirst(trim($request->name)),
            'barangay_name' => $request->barangayName,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'capacity' => trim($request->capacity),
            'is_archive' => 0,
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
        $this->evacuationCenter->find($evacuationId)->update([
            'is_archive' => 1,
            'status' => 'Archived'
        ]);
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
