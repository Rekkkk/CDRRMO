<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
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

    public function evacuationCenterList(Request $request)
    {
        $evacuationCenterList = $this->evacuationCenter->all();

        if ($request->ajax()) {
            return DataTables::of($evacuationCenterList)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="btn-edit p-1.5 mr-2 text-sm updateEvacuationCenter">Edit</a>' . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Remove" class="btn-cancel removeEvacuationCenter p-1.5 mr-2 text-sm">Remove</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('userpage.evacuationCenter.evacuation', compact('evacuationCenterList'));
    }

    public function registerEvacuationCenter(Request $request)
    {
        try {
            $this->evacuationCenter->create([
                'name' => Str::ucfirst($request->name),
                'barangay_name' => $request->barangay_name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 'Active'
            ]);
            $this->logActivity->generateLog('Registering Evacuation Center Information');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function updateEvacuationCenter(Request $request, $evacuationId)
    {
        try {
            $this->evacuationCenter->find($evacuationId)->update([
                'name' => Str::ucfirst(trim($request->name)),
                'barangay_name' => $request->barangay_name,
                'latitude' => trim($request->latitude),
                'longitude' => trim($request->longitude),
                'status' => $request->status
            ]);
            $this->logActivity->generateLog('Updating Evacuation Center Information');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function removeEvacuationCenter($evacuationId)
    {
        try {
            $this->evacuationCenter->find($evacuationId)->delete();
            $this->logActivity->generateLog('Removing Evacuation Center Information');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }
}
