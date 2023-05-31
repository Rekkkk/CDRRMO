<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barangay;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

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

        return view('userpage.barangay.barangay', compact('barangayList'));
    }
    public function getBarangayDetails($id)
    {
        if (request()->ajax()) {
            $data = Barangay::find($id);
            return response()->json(['result' => $data]);
        }
    }

    public function registerBarangay(Request $request)
    {
        $validatedBarangay = Validator::make($request->all(), [
            'barangay_name' => 'required',
            'barangay_location' => 'required',
            'barangay_contact' => 'required|numeric|digits:11',
            'barangay_email' => 'required|email:rfc,dns'
        ]);

        if ($validatedBarangay->passes()) {

            $barangayData = [
                'barangay_name' => Str::ucfirst(trim($request->barangay_name)),
                'barangay_location' => Str::ucfirst(trim($request->barangay_location)),
                'barangay_contact_number' => trim($request->barangay_contact),
                'barangay_email_address' => trim($request->barangay_email)
            ];

            try {
                $this->barangay->registerBarangayObject($barangayData);
                Alert::success(config('app.name'), 'Barangay Registered Successfully');

                ActivityUserLog::create([
                    'email' => Auth::user()->email,
                    'user_role' => Auth::user()->user_role,
                    'role_name' => Auth::user()->role_name,
                    'activity' => 'Registering Barangay',
                    'date_time' => Carbon::now()->toDayDateTimeString()
                ]);
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Register Barangay');
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
            'email' => 'required|email:rfc,dns'
        ]);

        if ($validatedBarangay->passes()) {

            $barangayData = [
                'barangay_name' => Str::ucfirst(trim($request->input('name'))),
                'barangay_location' => Str::ucfirst(trim($request->input('location'))),
                'barangay_contact_number' => trim($request->input('contact')),
                'barangay_email_address' => trim($request->input('email'))
            ];

            try {
                $this->barangay->updateBarangayObject($barangayData, $barangayId);
                Alert::success(config('app.name'), 'Barangay Updated Successfully.');

                ActivityUserLog::create([
                    'email' => Auth::user()->email,
                    'user_role' => Auth::user()->user_role,
                    'role_name' => Auth::user()->role_name,
                    'activity' => 'Updating Barangay',
                    'date_time' => Carbon::now()->toDayDateTimeString()
                ]);
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Update Barangay.');
            }
            return response()->json(['status' => 1]);
        }

        return response()->json(['status' => 0, 'error' => $validatedBarangay->errors()->toArray()]);
    }

    public function removeBarangay($barangayId)
    {
        try {
            $this->barangay->removeBarangayObject($barangayId);
            Alert::success(config('app.name'), 'Barangay Deleted Successfully.');

            ActivityUserLog::create([
                'email' => Auth::user()->email,
                'user_role' => Auth::user()->user_role,
                'role_name' => Auth::user()->role_name,
                'activity' => 'Deleting Barangay Information',
                'date_time' => Carbon::now()->toDayDateTimeString()
            ]);

        } catch (\Exception $e) {
            Alert::error(config('app.name'), 'Failed to Delete Barangay.');
        }

        return response()->json();
    }
}
