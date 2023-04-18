<?php

namespace App\Http\Controllers;

use App\Models\ReportAccident;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function displayCReport(Request $request)
    {
   
        $report = ReportAccident::latest()->get();
        
        if ($request->ajax()) {
            $data = ReportAccident::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                        //    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->report_id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm updateReport">Edit</a>';
   
                        //    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->report_id.'" data-original-title="Delete" class="btn btn-danger btn-sm removeReport">Delete</a>';
                            $btn ='<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->report_id.'" data-original-title="Delete" class="btn btn-danger btn-sm removeReport">Remove</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('CDRRMO.report.reportAccident',compact('report'));
    }

    public function displayGReport(Request $request)
    {
   
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

    public function addReport(Request $request)
    {

        $validatedGuideline = Validator::make($request->all(), [
            'report_description' => 'required',
            'report_location' => 'required',
            'contact' => 'required',
            'email' => 'required',
        ]);

        if($validatedGuideline->passes()) {

             ReportAccident::updateOrCreate(['report_id' => $request->report_id],
                ['report_description' => Str::ucFirst($request->report_description), 'report_location' => Str::of($request->report_location)->title(), 'contact' => $request->contact, 'email' => $request->email],
            );        
   
            return response()->json();
        }
       
        return response()->json();
    }

    public function removeReport($report_id)
    {
        ReportAccident::find($report_id)->delete();

       
        return response()->json(['success'=>'Report deleted successfully.']);
    }
}
