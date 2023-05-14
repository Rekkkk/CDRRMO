<?php

namespace App\Http\Controllers;

use App\Models\ActivityUserLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ReportAccident;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ReportAccidentController extends Controller
{

    private $reportAccident;

    function __construct()
    {
        $this->reportAccident = new ReportAccident;
    }

    public function displayCReport(Request $request)
    {
        $report = ReportAccident::latest()->get();

        if ($request->ajax()) {
            $data = ReportAccident::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $approved = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->report_id . '" data-original-title="Approve" class="approve bg-slate-700 hover:bg-slate-900 py-1.5 btn-sm mr-2 text-white approveAccidentReport">Approve</a>';
                    $btn = $approved . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->report_id . '" data-original-title="Delete" class="bg-red-700 hover:bg-red-900 py-1.5 btn-sm mr-2 text-white removeAccidentReport">Remove</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('userpage.reportAccident.reportAccident', compact('report'));
    }

    public function displayGReport(Request $request)
    {
        $report = ReportAccident::latest()->get();

        if ($request->ajax()) {
            $data = ReportAccident::latest()->get();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        return view('userpage.reportAccident.reportAccident', compact('report'));
    }

    public function addAccidentReport(Request $request)
    {
        $validatedAccidentReport = Validator::make($request->all(), [
            'report_description' => 'required',
            'report_location' => 'required',
            'report_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'contact' => 'required|numeric|digits_between:11,15',
            'email' => 'required|email'
        ]);

        if ($validatedAccidentReport->passes()) {
            $imageName = time() . '.' . $request->report_photo->extension();

            $request->report_photo->move(public_path('reports_image'), $imageName);

            $reportAccident = [
                'report_description' => Str::ucFirst(trim($request->report_description)),
                'report_location' => Str::of(trim($request->report_location))->title(),
                'report_photo' => $imageName,
                'contact' => trim($request->contact),
                'email' => trim($request->email),
                'status' => 'On Process'
            ];

            try {
                $this->reportAccident->registerAccidentReportObject($reportAccident);
            } catch (\Exception $e) {
                Alert::success(config('app.name'), 'Failed to Report Accident.');
            }

            $currentDate = Carbon::now();
            $todayDate = $currentDate->toDayDateTimeString();

            ActivityUserLog::create([
                'user_id' => '0',
                'email' => trim($request->email),
                'user_role' => '0',
                'role_name' => 'Resident',
                'activity' => 'Registering Accident Report',
                'date_time' => $todayDate,
            ]); 

            return response()->json(['condition' => 1]);
        }

        return response()->json(['condition' => 0, 'error' => $validatedAccidentReport->errors()->toArray()]);
    }

    public function approveAccidentReport($reportId)
    {

        ReportAccident::where('report_id', $reportId)->update([
            'status' => 'Approved'
        ]);

        $currentDate = Carbon::now();
        $todayDate = $currentDate->toDayDateTimeString();

        ActivityUserLog::create([
            'user_id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'user_role' => Auth::user()->user_role,
            'role_name' => Auth::user()->role_name,
            'activity' => 'Approving Accident Report',
            'date_time' => $todayDate,
        ]);

        return response()->json();
    }

    public function removeAccidentReport($reportAccidentId)
    {
        try {
            $this->reportAccident->removeAccidentReportObject($reportAccidentId);
            $currentDate = Carbon::now();
            $todayDate = $currentDate->toDayDateTimeString();

            ActivityUserLog::create([
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'user_role' => Auth::user()->user_role,
                'role_name' => Auth::user()->role_name,
                'activity' => 'Removing Accident Report',
                'date_time' => $todayDate,
            ]);
        } catch (\Exception $e) {
            Alert::success(config('app.name'), 'Failed to Report Accident.');
        }



        return response()->json();
    }
}
