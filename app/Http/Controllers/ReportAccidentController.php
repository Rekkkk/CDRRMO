<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ReportAccident;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class ReportAccidentController extends Controller{
    public function displayCReport(Request $request){
   
        $report = ReportAccident::latest()->get();

        if ($request->ajax()) {
            $data = ReportAccident::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $approved = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->report_id.'" data-original-title="Approve" class="approve bg-slate-700 hover:bg-slate-900 py-1.5 btn-sm mr-2 text-white approveReport">Approve</a>';
                            $btn = $approved . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->report_id.'" data-original-title="Delete" class="bg-red-700 hover:bg-red-900 py-1.5 btn-sm mr-2 text-white removeReport">Remove</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('CDRRMO.reportAccident.reportAccident', compact('report'));
    }

    public function displayGReport(Request $request){
   
        $report = ReportAccident::latest()->get();
        
        if ($request->ajax()) {
            $data = ReportAccident::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    
                })
                ->rawColumns(['action'])
                ->make(true);
        }
      
        return view('CDRRMO.reportAccident.reportAccident',compact('report'));
    }

    public function addReport(Request $request){

        $validatedAccidentReport = Validator::make($request->all(), [
            'report_description' => 'required',
            'report_location' => 'required',
            'contact' => 'required',
            'email' => 'required',
        ]);

        if($validatedAccidentReport->passes()) {

             ReportAccident::updateOrCreate(['report_id' => $request->report_id],
                [
                    'report_description' => Str::ucFirst(trim($request->report_description)), 
                    'report_location' => Str::of(trim($request->report_location))->title(), 
                    'contact' => trim($request->contact), 
                    'email' => trim($request->email),
                    'status' => 'On Process'
                ],
            );
        }
        
        return response()->json();
    }

    public function approveReport($reportId){

        ReportAccident::where('report_id', $reportId)->update([
            'status' => 'Approved',
        ]);

        return response()->json();
    }

    public function removeReport($reportId){
        ReportAccident::find($reportId)->delete();
       
        return response()->json();
    }
}