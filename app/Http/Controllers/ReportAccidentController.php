<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ReportAccident;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ReportAccidentController extends Controller{

    private $reportAccident;

    function __construct(){
        $this->reportAccident = new ReportAccident;
    }

    public function displayCReport(Request $request){
        $report = ReportAccident::latest()->get();

        if ($request->ajax()) {
            $data = ReportAccident::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $approved = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->report_id.'" data-original-title="Approve" class="approve bg-slate-700 hover:bg-slate-900 py-1.5 btn-sm mr-2 text-white approveAccidentReport">Approve</a>';
                            $btn = $approved . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->report_id.'" data-original-title="Delete" class="bg-red-700 hover:bg-red-900 py-1.5 btn-sm mr-2 text-white removeAccidentReport">Remove</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('cdrrmo.reportAccident.reportAccident', compact('report'));
    }

    public function displayGReport(Request $request){
        $report = ReportAccident::latest()->get();

        if ($request->ajax()) {
            $data = ReportAccident::latest()->get();
            return DataTables::of($data)->addIndexColumn()->make(true);
        }
      
        return view('cdrrmo.reportAccident.reportAccident', compact('report'));
    }

    public function addAccidentReport(Request $request){
        $validatedAccidentReport = Validator::make($request->all(), [
            'report_description' => 'required',
            'report_location' => 'required',
            'contact' => 'required|numeric|digits_between:11,15',
            'email' => 'required|email',
            'report_photo' => 'required',
        ]);

        if($validatedAccidentReport->passes()) {

            $reportAccident = [
                'report_description' => Str::ucFirst(trim($request->report_description)),
                'report_location' => Str::of(trim($request->report_location))->title(),
                'report_photo' => $request->report_photo,
                'contact' => trim($request->contact),
                'email' => trim($request->email),
                'status' => 'On Process'
            ];

            try{
                $this->reportAccident->registerAccidentReportObject($reportAccident);
            }catch(\Exception $e){
                Alert::success('Failed to Report Accident', 'Cabuyao City Disaster Risk Reduction Management Office');
            }

            return response()->json(['condition' => 1]);
        }
        
        return response()->json(['condition' => 0, 'error' => $validatedAccidentReport->errors()->toArray()]);
    }

    public function approveAccidentReport($reportId){

        ReportAccident::where('report_id', $reportId)->update([
            'status' => 'Approved',
        ]);

        return response()->json();
    }

    public function removeAccidentReport($reportAccidentId){
        try{
            $this->reportAccident->removeAccidentReportObject($reportAccidentId);
        }catch(\Exception $e){
            Alert::success('Failed to Report Accident', 'Cabuyao City Disaster Risk Reduction Management Office');
        }
        
        return response()->json();
    }
}