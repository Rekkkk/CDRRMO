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
    private $guide;

    function __construct(){
        $this->guideline = new Guideline;
        $this->guide = new Guide;
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

            $guidelineData = [
                'guideline_description' => Str::upper(trim("E-LIGTAS $request->guideline_description Guideline")),
            ];

            try{
                $this->guideline->registerGuidelineObject($guidelineData);
            }catch(\Exception $e){
                Alert::error('Failed to Add Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
            }

            return response()->json(['condition' => 1]);
        }

        return response()->json(['condition' => 0, 'error' => $validatedGuideline->errors()->toArray()]);
    }

    public function updateGuideline(Request $request, $guidelineId){
        $validatedGuideline = Validator::make($request->all(), [
            'guideline_description' => 'required',
        ]);

        if($validatedGuideline->passes()){

            try{
                $this->guideline->updateGuidelineObject($request, $guidelineId);
            }catch(\Exception $e){
                Alert::error('Failed to Add Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
            }
            
            return back();
        }

        Alert::error('Failed to Add Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
        return back();
    }

    public function removeGuideline($guidelineId){

        try{
            $this->guideline->removeGuidelineObject($guidelineId);
            Alert::success('Disaster Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Add Guideline', 'Cabuyao City Disaster Risk Reduction Management Office');
        }

        return back();
    }

    public function guide($guidelineId){
        $guide = array("guide" => DB::table('guide')->where('guideline_id', $guidelineId)->orderBy('guide_id', 'asc')->simplePaginate(5));
        
        return $guide;
    }

    public function addGuide(Request $request, $guidelineId){
        $validatedGuide = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required',
        ]);

        if($validatedGuide->passes()) {
            $guideData = [
                'guide_description' => Str::of(trim($request->guide_description))->title(),
                'guide_content' => Str::ucFirst(trim($request->guide_content)),
                'guideline_id' => $guidelineId,
            ];

            try{
                $this->guide->registerGuideObject($guideData);
            }catch(\Exception $e){
                Alert::error('Failed to Add Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
            }

            return response()->json(['condition' => 1]);
        }
        
        return response()->json(['condition' => 0, 'error' => $validatedGuide->errors()->toArray()]);
    }

    public function updateGuide(Request $request, $guideId){
        $validatedGuide = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required',
        ]);

        if($validatedGuide->passes()){
            
            try{
                $this->guide->updateGuideObject($request, $guideId);
            }catch(\Exception $e){
                Alert::error('Failed to Add Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
            }
            
            return back();
        }
        return back();
    }

    public function removeGuide($guideId){

        try{
            $this->guide->removeGuideObject($guideId);
            Alert::success('Guide Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Deleted Guide', 'Cabuyao City Disaster Risk Reduction Management Office');
        }

        return back();
    }
}