<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Guide;
use App\Models\Guidelines;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GuidelinesController extends Controller
{
    public function guide($guideline_id){
        $guide = array("guide" => DB::table('guide')->where('guidelines_id', $guideline_id)->orderBy('guide_id', 'asc')->simplePaginate(5));
        
        return $guide;
    }

    public function guidelines(){
        $guidelines = array("guidelines" => DB::table('guidelines')->orderBy('guidelines_id', 'asc')->simplePaginate(10));
        
        return $guidelines;
    }

    public function addGuide(Request $request, $guideline_id){

        $validatedGuideline = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required',
        ]);

        if($validatedGuideline->passes()) {

            Guide::create([
                'guide_description' => Str::upper(trim($request->guide_description)),
                'guide_content' => Str::upper(trim($request->guide_content)),
                'guidelines_id' => $guideline_id,
            ]);

            Alert::success('Guide Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guide/' . $guideline_id);
        }

        Alert::error('Failed to Post Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/eligtasGuidelines/guide/' . $guideline_id);
    }

    public function updateGuide(Request $request, $guide_id){

        $validatedGuide = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required',
        ]);

        if($validatedGuide->passes()){

            $updatedGuide = Guide::where('guide_id', $guide_id)->update([
                'guide_description' => Str::upper(trim($request->input('guide_description'))),
                'guide_content' => Str::upper(trim($request->input('guide_content'))),
            ]);

            
            if($updatedGuide){
                Alert::success('Guide Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuidelines/guide/'. $request->input('guidelines_id'));
            }
            else{
                Alert::error('Failed to Update Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuidelines/guide/' . $request->input('guidelines_id'));
            }
        }

        return redirect('cdrrmo/eligtasGuidelines/guide/');
    }

    public function removeGuide($guide_id){
        $guide = DB::table('guide')->where('guide_id', $guide_id)->get();
        $deletedGuide = DB::table('guide')->where('guide_id', $guide_id)->delete();
        
        if($deletedGuide){
            Alert::success('Guide Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guide/' . $guide->first()->guidelines_id);
        }
        else{
            Alert::error('Failed to Deleted Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guide/' . $guide->first()->guidelines_id);
        }
    }

    public function addGuidelines(Request $request){

        $validatedGuideline = Validator::make($request->all(), [
            'guidelines_description' => 'required',
        ]);

        if($validatedGuideline->passes()) {

            Guidelines::create([
                'guidelines_description' => Str::upper(trim("E-LIGTAS $request->guidelines_description")),
            ]);

            Alert::success('Guidelines Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines');
        }

        Alert::error('Failed to Post Guidelines', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/eligtasGuidelines');
    }

    public function updateGuidelines(Request $request, $guidelines_id){

        $validatedGuideline = Validator::make($request->all(), [
            'guideline_description' => 'required',
        ]);

        if($validatedGuideline->passes()){

            $updatedGuidelines = Guidelines::where('guidelines_id', $guidelines_id)->update([
                'guidelines_description' => Str::upper(trim($request->input('guideline_description'))),
            ]);

            if($updatedGuidelines){
                Alert::success('Guideline Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuidelines');
            }
            else{
                Alert::error('Failed to Update Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuidelines');
            }
        }

        return redirect('cdrrmo/eligtasGuidelines');
    }

    public function removeGuidelines($guideline_id){
        $deletedGuideline = DB::table('guidelines')->where('guidelines_id', $guideline_id)->delete();

        if($deletedGuideline){
            Alert::success('Guideline Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines');
        }
        else{
            Alert::error('Failed to Deleted Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines');
        }
    }

}
