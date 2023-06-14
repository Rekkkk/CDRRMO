<?php

namespace App\Http\Controllers;

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
        $this->evacuationCenter = new EvacuationCenter;
        $this->logActivity = new ActivityUserLog;
    }

    public function evacuationCenterList(Request $request)
    {
        $evacuationCenterList = EvacuationCenter::all();

        if ($request->ajax()) {
            $data = EvacuationCenter::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="bg-slate-700 hover:bg-slate-900 py-1.5 btn-sm mr-2 text-white updateEvacuationCenter">Edit</a>';
                    $btn = $editBtn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Remove" class="bg-red-700 hover:bg-red-900 py-1.5 btn-sm mr-2 text-white removeEvacuationCenter">Remove</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('userpage.evacuationCenter.evacuation', compact('evacuationCenterList'));
    }

    public function registerEvacuationCenter(Request $request)
    {
        $validatedEvacuationCenter = Validator::make($request->all(), [
            'name' => 'required',
            'barangay_name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if ($validatedEvacuationCenter->passes()) {

            $evacuationCenterData = [
                'name' => Str::ucfirst($request->name),
                'barangay_name' => $request->barangay_name,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 'Active'
            ];

            try {
                $this->evacuationCenter->registerEvacuationCenterObject($evacuationCenterData);
                $this->logActivity->generateLog('Registering Evacuation Center Information');

                return response()->json(['status' => 1]);
            } catch (\Exception $e) {
                return response()->json(['status' => 0]);
            }
        }
        return response()->json(['status' => 0, 'error' => $validatedEvacuationCenter->errors()->toArray()]);
    }

    public function updateEvacuationCenter(Request $request, $evacuationId)
    {
        $validatedEvacuationCenter = Validator::make($request->all(), [
            'name' => 'required',
            'barangay_name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'status' => 'required'
        ]);

        if ($validatedEvacuationCenter->passes()) {

            $evacuationCenterData = [
                'name' => Str::ucfirst(trim($request->name)),
                'barangay_name' => $request->barangay_name,
                'latitude' => trim($request->latitude),
                'longitude' => trim($request->longitude),
                'status' => $request->status
            ];

            try {
                $this->evacuationCenter->updateEvacuationCenterObject($evacuationCenterData, $evacuationId);
                $this->logActivity->generateLog('Updating Evacuation Center Information');

                return response()->json(['status' => 1]);
            } catch (\Exception $e) {
                return response()->json(['status' => 0]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validatedEvacuationCenter->errors()->toArray()]);
    }

    public function getEvacuationCenterDetails($id)
    {
        if (request()->ajax()) {
            $data = EvacuationCenter::find($id);
            return response()->json(['result' => $data]);
        }
    }

    public function removeEvacuationCenter($evacuationId)
    {
        try {
            $this->evacuationCenter->removeEvacuationCenterObject($evacuationId);
            $this->logActivity->generateLog('Removing Evacuation Center Information');
            
            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }
}
