<?php

namespace App\Http\Controllers;

use App\Models\ReportAccident;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReportController extends Controller
{
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
      
        return view('CDRRMO.report.reportAccident', compact('report'));
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
      
        return view('CDRRMO.report.reportAccident',compact('report'));
    }

    public function addReport(Request $request){

        $validatedGuideline = Validator::make($request->all(), [
            'report_description' => 'required',
            'report_location' => 'required',
            'contact' => 'required',
            'email' => 'required',
        ]);

        if($validatedGuideline->passes()) {

             ReportAccident::updateOrCreate(['report_id' => $request->report_id],
                [
                    'report_description' => Str::ucFirst($request->report_description), 
                    'report_location' => Str::of($request->report_location)->title(), 
                    'contact' => $request->contact, 
                    'email' => $request->email,
                    'status' => 'On Process'
                ],
            );
        }
        
        return response()->json();
    }

    public function approveReport($report_id){

        ReportAccident::where('report_id', $report_id)->update([
            'status' => 'Approved',
        ]);

        return response()->json();
    }

    public function removeReport($report_id){
        ReportAccident::find($report_id)->delete();
       
        return response()->json();
    }
}
