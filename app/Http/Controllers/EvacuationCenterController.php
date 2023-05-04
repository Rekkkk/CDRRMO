<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvacuationCenterRequest;
use Illuminate\Support\Str;
use App\Models\EvacuationCenter;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EvacuationCenterController extends Controller{
    private $evacuationCenter;

    function __construct(){
        $this->evacuationCenter = new EvacuationCenter;
    }

    public function evacuationCenterList(){
        $EvacuationCenterList = array("evacuationCenter" => DB::table('evacuation_center')->orderBy('evacuation_center_id', 'asc')->simplePaginate(5));

        return $EvacuationCenterList;
    }

    public function registerEvacuationCenter(EvacuationCenterRequest $request){
        $evacuationCenterData = [
            'evacuation_center_name' => Str::ucfirst($request->evacuation_center_name),
            'evacuation_center_contact' => $request->evacuation_center_contact,
            'evacuation_center_address' => Str::ucfirst($request->evacuation_center_address),
        ];

        try{
            $this->evacuationCenter->registerEvacuationCenterObject($evacuationCenterData);
            Alert::success('Evacuation Center Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Register Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
        }
            
        return back();
    }

    public function updateEvacuationCenter(EvacuationCenterRequest $request, $evacuationId){
        try{
            $this->evacuationCenter->updateEvacuationCenterObject($request, $evacuationId);
            Alert::success('Evacuation Center Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Update Evacuation Center', 'Cabuyao City Disaster Risk Reduction Management Office');
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