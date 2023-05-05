<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class BarangayController extends Controller
{
    private $barangay;

    function __construct()
    {
        $this->barangay = new Barangay;
    }

    public function barangayList(Request $request)
    {
        $barangayList = Barangay::all();

        if ($request->ajax()) {
            $data = Barangay::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->barangay_id . '" data-original-title="Edit" class="bg-slate-700 hover:bg-slate-900 py-1.5 btn-sm mr-2 text-white updateBarangay">Edit</a>';
                    $btn = $editBtn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->barangay_id . '" data-original-title="Remove" class="bg-red-700 hover:bg-red-900 py-1.5 btn-sm mr-2 text-white removeBarangay">Remove</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('cdrrmo.barangay.barangay', compact('barangayList'));
    }

    public function registerBarangay(Request $request)
    {
        $validatedBarangay = Validator::make($request->all(), [
            'barangay_name' => 'required',
            'barangay_location' => 'required',
            'barangay_contact' => 'required|numeric|digits:11',
            'barangay_email' => 'required|email:rfc,dns',
        ]);

        if ($validatedBarangay->passes()) {

            $barangayData = [
                'barangay_name' => Str::ucfirst(trim($request->barangay_name)),
                'barangay_location' => Str::ucfirst(trim($request->barangay_location)),
                'barangay_contact_number' => trim($request->barangay_contact),
                'barangay_email_address' => trim($request->barangay_email),
            ];

            try {
                $this->barangay->registerBarangayObject($barangayData);
                Alert::success('Barangay Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            } catch (\Exception $e) {
                Alert::error('Failed to Register Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
            }

            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0, 'error' => $validatedBarangay->errors()->toArray()]);
    }

    public function updateBarangay(Request $request, $barangayId)
    {
        $validatedBarangay = Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'contact' => 'required|numeric|digits:11',
            'email' => 'required|email:rfc,dns',
        ]);

        if ($validatedBarangay->passes()) {

            $barangayData = [
                'barangay_name' => Str::ucfirst(trim($request->input('name'))),
                'barangay_location' => Str::ucfirst(trim($request->input('location'))),
                'barangay_contact_number' => trim($request->input('contact')),
                'barangay_email_address' => trim($request->input('email')),
            ];

            try {
                $this->barangay->updateBarangayObject($barangayData, $barangayId);
                Alert::success('Barangay Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            } catch (\Exception $e) {
                Alert::error('Failed to Update Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
            }
            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0, 'error' => $validatedBarangay->errors()->toArray()]);
    }

    public function getBarangayDetails($id)
    {
        if(request()->ajax())
        {
            $data = Barangay::find($id);
            return response()->json(['result' => $data]);
        }
    }

    public function removeBarangay($barangayId)
    {
        try {
            $this->barangay->removeBarangayObject($barangayId);
            Alert::success('Barangay Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        } catch (\Exception $e) {
            Alert::error('Failed to Delete Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
        }

        return response()->json();
    }
}
