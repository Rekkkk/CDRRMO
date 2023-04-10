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

    public function updateGuide(Request $request, $guide_id){

        $validatedGuideline = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required',
        ]);

        if($validatedGuideline->passes()){

            $guide_description = $request->input('guide_description');
            $guide_content = $request->input('guide_content');

            $updatedGuide = Guide::where('guide_id', $guide_id)->update([
                'guide_description' => $guide_description,
                'guide_content' => $guide_content,
            ]);

            if($updatedGuide){
                Alert::success('Guide Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuidelines/guide');
            }
            else{
                Alert::error('Failed to Update Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuidelines/guide');
            }
        }

        return redirect('cdrrmo/eligtasGuidelines/guide');
    }

    public function removeGuide($guide_id){
        $deletedGuide = DB::table('guide')->where('guide_id', $guide_id)->delete();

        if($deletedGuide){
            Alert::success('Guide Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guide');
        }
        else{
            Alert::error('Failed to Deleted Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuidelines/guide');
        }
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

}
