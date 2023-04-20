<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Guideline;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class GuidelineController extends Controller{
    private $guideline;

    function __construct(){

        $this->guideline = new Guideline;

    }

    public function guideline(){

        $guideline = $this->guideline->displayGuideline();

        return compact('guideline');

    }

    public function addGuideline(Request $request){

        $validatedGuideline = Validator::make($request->all(), [
            'guideline_description' => 'required',
        ]);

        if($validatedGuideline->passes()) {

            Guideline::create([
                'guideline_description' => Str::upper(trim("E-LIGTAS $request->guideline_description Guideline")),
            ]);

            Alert::success('Guideline Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return back();

        }

        Alert::error('Failed to Post Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
        return back();

    }

    public function updateGuideline(Request $request, $guidelineId){

        $validatedGuideline = Validator::make($request->all(), [
            'guideline_description' => 'required',
        ]);

        if($validatedGuideline->passes()){

            $updatedGuideline = Guideline::where('guideline_id', $guidelineId)->update([
                'guideline_description' => Str::upper(trim($request->input('guideline_description'))),
            ]);

            if($updatedGuideline){

                Alert::success('Guideline Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                
                return back();

            }
            else{

                Alert::error('Failed to Update Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
                return back();

            }
        }

        return back();

    }

    public function removeGuideline($guidelineId){

        $deletedGuideline = DB::table('guideline')->where('guideline_id', $guidelineId)->delete();

        if($deletedGuideline){

            Alert::success('Guideline Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return back();

        }
        else{

            Alert::error('Failed to Deleted Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
            return back();

        }
    }

    public function guide($guidelineId){

        $guide = array("guide" => DB::table('guide')->where('guideline_id', $guidelineId)->orderBy('guide_id', 'asc')->simplePaginate(5));
        
        return $guide;

    }

    public function addGuide(Request $request, $guidelineId){

        $validatedGuideline = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required',
        ]);

        if($validatedGuideline->passes()) {

            Guide::create([
                'guide_description' => Str::of(trim($request->guide_description))->title(),
                'guide_content' => Str::ucFirst(trim($request->guide_content)),
                'guideline_id' => $guidelineId,
            ]);

            Alert::success('Guide Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuideline/guide/' . $guidelineId);

        }

        Alert::error('Failed to Post Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/eligtasGuideline/guide/' . $guidelineId);

    }

    public function updateGuide(Request $request, $guideId){

        $validatedGuide = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required',
        ]);

        if($validatedGuide->passes()){

            $updatedGuide = Guide::where('guide_id', $guideId)->update([
                'guide_description' => Str::upper(trim($request->input('guide_description'))),
                'guide_content' => Str::upper(trim($request->input('guide_content'))),
            ]);
            
            if($updatedGuide){

                Alert::success('Guide Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuideline/guide/'. $request->input('guideline_id'));

            }
            else{

                Alert::error('Failed to Update Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/eligtasGuideline/guide/' . $request->input('guideline_id'));

            }
        }

        return back();
    }

    public function removeGuide($guideId){

        $guide = DB::table('guide')->where('guide_id', $guideId)->get();
        $deletedGuide = DB::table('guide')->where('guide_id', $guideId)->delete();
        
        if($deletedGuide){

            Alert::success('Guide Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuideline/guide/' . $guide->first()->guideline_id);

        }
        else{

            Alert::error('Failed to Deleted Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/eligtasGuideline/guide/' . $guide->first()->guideline_id);

        }

    }
}