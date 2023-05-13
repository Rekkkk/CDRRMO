<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvacuationCenterRequest;
use Illuminate\Support\Str;
use App\Models\EvacuationCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class EvacuationCenterController extends Controller
{
    private $evacuationCenter;

    function __construct()
    {
        $this->evacuationCenter = new EvacuationCenter;
    }

    public function evacuationCenterList(Request $request)
    {
        $evacuationCenterList = EvacuationCenter::all();

        if ($request->ajax()) {
            $data = EvacuationCenter::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->evacuation_center_id . '" data-original-title="Edit" class="bg-slate-700 hover:bg-slate-900 py-1.5 btn-sm mr-2 text-white updateEvacuationCenter">Edit</a>';
                    $btn = $editBtn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->evacuation_center_id . '" data-original-title="Remove" class="bg-red-700 hover:bg-red-900 py-1.5 btn-sm mr-2 text-white removeEvacuationCenter">Remove</a>';
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
            'evacuation_center_name' => 'required',
            'evacuation_center_contact' => 'required|numeric|digits:11',
            'evacuation_center_address' => 'required',
            'barangay_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validatedEvacuationCenter->passes()) {

            $evacuationCenterData = [
                'evacuation_center_name' => Str::ucfirst($request->evacuation_center_name),
                'evacuation_center_contact' => $request->evacuation_center_contact,
                'evacuation_center_address' => Str::ucfirst($request->evacuation_center_address),
                'barangay_id' => $request->barangay_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];

            try {
                $this->evacuationCenter->registerEvacuationCenterObject($evacuationCenterData);
                Alert::success('Evacuation Center Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            } catch (\Exception $e) {
                Alert::error('Failed to Register Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
            }

            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0, 'error' => $validatedEvacuationCenter->errors()->toArray()]);
    }

    public function updateEvacuationCenter(Request $request, $evacuationId)
    {
        $validatedEvacuationCenter = Validator::make($request->all(), [
            'evacuation_name' => 'required',
            'evacuation_contact' => 'required|numeric|digits:11',
            'evacuation_address' => 'required',
            'barangay_evacuation_id' => 'required',
            'evacuation_latitude' => 'required',
            'evacuation_longitude' => 'required',
        ]);

        if ($validatedEvacuationCenter->passes()) {

            $evacuationCenterData = [
                'evacuation_center_name' => Str::ucfirst(trim($request->input('evacuation_name'))),
                'evacuation_center_contact' => trim($request->input('evacuation_contact')),
                'evacuation_center_address' => Str::ucfirst(trim($request->input('evacuation_address'))),
                'barangay_id' => $request->input('barangay_evacuation_id'),
                'latitude' => trim($request->input('evacuation_latitude')),
                'longitude' => trim($request->input('evacuation_longitude')),
            ];

            try {
                $this->evacuationCenter->updateEvacuationCenterObject($evacuationCenterData, $evacuationId);
                Alert::success('Evacuation Center Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            } catch (\Exception $e) {
                Alert::error('Failed to Update Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
            }

            return response()->json(['status' => 1]);
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
            Alert::success('Evacuation Center Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        } catch (\Exception $e) {
            Alert::error('Failed to Deleted Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
        }

        return response()->json();
    }
}
