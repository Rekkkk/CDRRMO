<?php

namespace App\Http\Controllers;

use App\Models\Guidelines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GuidelinesController extends Controller
{
    public function guidelines(){
        $guidelines = Guidelines::all();
        
       return view('CDRRMO.guidelines.guidelines', ['guidelines' => $guidelines]);
    }

    public function addGuidelines(Request $request){

        $validatedGuideline = Validator::make($request->all(), [
            'guidelines_description' => 'required',
            'guidelines_content' => 'required',
        ]);

        if($validatedGuideline->passes()) {

            Guidelines::create([
                'guidelines_description' => $request->guidelines_description,
                'guidelines_content' => $request->guidelines_content,
            ]);

            Alert::success('Guidelines Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guidelines');
        }

        Alert::error('Failed to Post Guidelines', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/eligtasGuidelines/guidelines');
    }

    public function updateGuidelines(Request $request, $guideline_id){

        $validatedGuideline = Validator::make($request->all(), [
            'guidelines_description' => 'required',
            'guidelines_content' => 'required',
        ]);

        if($validatedGuideline->passes()){

            $guidelines_description = $request->input('guidelines_description');
            $guidelines_content = $request->input('guidelines_content');

            $updatedGuidelines = Guidelines::where('guidelines_id', $guideline_id)->update([
                'guidelines_description' => $guidelines_description,
                'guidelines_content' => $guidelines_content,
            ]);

            if($updatedGuidelines){
                Alert::success('Guidelines Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuidelines/guidelines');
            }
            else{
                Alert::error('Failed to Update Guidelines', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuidelines/guidelines');
            }
        }

        return redirect('cdrrmo/eligtasGuidelines/guidelines');
    }

    public function removeGuidelines($guideline_id){
        $deletedGuideline = DB::table('guidelines')->where('guidelines_id', $guideline_id)->delete();

        if($deletedGuideline){
            Alert::success('Guideline  Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guidelines');
        }
        else{
            Alert::error('Failed to Deleted Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guidelines');
        }
    }

}
