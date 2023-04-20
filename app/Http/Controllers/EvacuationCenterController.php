<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EvacuationCenter;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class EvacuationCenterController extends Controller{
    private $evacuationCenter;

    function __construct(){
        $this->evacuationCenter = new EvacuationCenter;
    }

    public function evacuationCenterList(){
        $EvacuationCenterList = array("evacuationCenter" => DB::table('evacuation_center')->orderBy('evacuation_center_id', 'asc')->simplePaginate(4));

        return $EvacuationCenterList;
    }

    public function registerEvacuationCenter(Request $request){
        $validatedEvacuationCenter = Validator::make($request->all(), [
            'evacuation_center_name' => 'required',
            'evacuation_center_contact' => 'required',
            'evacuation_center_location' => 'required',
        ]);

        if($validatedEvacuationCenter->passes()) {

            $evacuationCenterData = [
                'evacuation_center_name' => Str::ucfirst($request->evacuation_center_name),
                'evacuation_center_contact' => $request->evacuation_center_contact,
                'evacuation_center_location' => Str::ucfirst($request->evacuation_center_location),
            ];

            try{
                $this->evacuationCenter->registerEvacuationCenterObject($evacuationCenterData);
                Alert::success('Evacuation Center Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            }catch(\Exception $e){
                Alert::error('Failed to Register Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
            }
            
            return back();
        }

        Alert::error('Failed to Register Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
        return back();
    }

    public function updateEvacuationCenter(Request $request, $evacuationId){
        $validatedEvacuationCenter = Validator::make($request->all(), [
            'evacuation_center_name' => 'required',
            'evacuation_center_contact' => 'required',
            'evacuation_center_location' => 'required',
        ]);

        if($validatedEvacuationCenter->passes()){

            try{
                $this->evacuationCenter->updateEvacuationCenterObject($request, $evacuationId);
                Alert::success('Evacuation Center Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            }catch(\Exception $e){
                Alert::error('Failed to Update Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
            }

            return back();
        }

        return back();
    }

    public function removeEvacuationCenter($evacuationId){
    
        try{
            $this->evacuationCenter->removeEvacuationCenterObject($evacuationId);
            Alert::success('Evacuation Center Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Deleted Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
        }

        return back();
    }
}