<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Guidelines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GuidelinesController extends Controller
{
    public function guide(){
        $guide = array("guide" => DB::table('guide')->orderBy('guide_id', 'asc')->simplePaginate(5));
        
        return $guide;
    }

    public function guidelines(){
        $guidelines = array("guidelines" => DB::table('guidelines')->orderBy('guidelines_id', 'asc')->simplePaginate(10));
        
        return $guidelines;
    }

    public function addGuide(Request $request){

        $validatedGuideline = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required',
        ]);

        if($validatedGuideline->passes()) {

            Guide::create([
                'guide_description' => $request->guide_description,
                'guide_content' => $request->guide_content,
            ]);

            Alert::success('Guide Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guide');
        }

        Alert::error('Failed to Post Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/eligtasGuidelines/guide');
    }

    public function addGuidelines(Request $request){

        $validatedGuideline = Validator::make($request->all(), [
            'guidelines_description' => 'required',
        ]);

        if($validatedGuideline->passes()) {

            Guidelines::create([
                'guidelines_description' => $request->guidelines_description,
            ]);

            Alert::success('Guidelines Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines');
        }

        Alert::error('Failed to Post Guidelines', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/eligtasGuidelines');
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
