<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use App\Models\EvacuationCenter;
use App\Models\Evacuee;
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
            ->addColumn('capacity', function ($row) {
                $currentEvacuees = Evacuee::where('evacuation_assigned', $row->name)->sum('individuals');
                return $currentEvacuees . '/' . $row->capacity;
            })
            ->addColumn('status', function ($row) {
                return match ($row->status) {
                    'Active' => '<div class="text-green-600 font-extrabold">Active</div>',
                    'Inactive' => '<div class="text-red-600 font-extrabold">Inactive</div>',
                    'Full' => '<div class="text-orange-500 font-extrabold">Full</div>',
                };
            })->addColumn('action', function ($row) use ($operation) {
                if ($operation == "locator") {
                    return match ($row->status) {
                        'Full' => "<span class='text-sm'>Currently full can't evacuate.</span>",
                        'Inactive' => "<span class='text-sm'>Currently Inactive can't evacuate.</span>",
                        'Active' => '<button class="btn-table-primary p-2 w-24 text-white locateEvacuationCenter"><i class="bi bi-search pr-2"></i>Locate</button>'
                    };
                } else {
                    if (auth()->user()->is_disable == 0) {
                        return '<div class="flex justify-around actionContainer"><button class="btn-table-update w-28 mr-2 updateEvacuationCenter"><i class="bi bi-pencil-square pr-2"></i>Update</button>' .
                            '<button class="btn-table-remove w-28 mr-2 removeEvacuationCenter"><i class="bi bi-trash3-fill pr-2"></i>Remove</button>' .
                            '<select class="form-select w-44 bg-blue-500 text-white drop-shadow-md changeEvacuationStatus">
                                    <option value="" disabled selected hidden>Change Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Full">Full</option>
                                </select></div>';
                    }
                }

                return '<span class="text-sm">Currently Disabled.</span>';
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

        if ($validateEvacuationCenter->passes()) {
            $this->evacuationCenter->create([
                'name' => Str::ucfirst($request->name),
                'barangay_name' => $request->barangayName,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'capacity' => $request->capacity,
                'status' => 'Active'
            ]);
            $this->logActivity->generateLog('Added new evacuation center');

            return response()->json();
        }

        return response(['status' => "warning", 'message' => $validateEvacuationCenter->errors()->first()]);
    }

    public function updateEvacuationCenter(Request $request, $evacuationId)
    {
        $validateEvacuationCenter = Validator::make($request->all(), [
            'name' => 'required',
            'barangayName' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if ($validateEvacuationCenter->passes()) {
            $this->evacuationCenter->find($evacuationId)->update([
                'name' => Str::ucfirst(trim($request->name)),
                'barangay_name' => $request->barangayName,
                'latitude' => trim($request->latitude),
                'longitude' => trim($request->longitude),
                'capacity' => $request->capacity
            ]);
            $this->logActivity->generateLog('Updating evacuation center');

            return response()->json();
        }

        return response(['status' => "warning", 'message' => $validateEvacuationCenter->errors()->first()]);
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
