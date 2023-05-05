<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisasterRequest;
use App\Models\Disaster;
use RealRashid\SweetAlert\Facades\Alert;

class DisasterController extends Controller{
    private $disaster;

    function __construct() {
        $this->disaster = new Disaster;
    }

    public function disasterList(){
        $disaster = $this->disaster->displayDisasterObject();

        return compact('disaster');
    }

    // public function registerDisaster(DisasterRequest $request){
        
    //     $disasterData = [
    //         'disaster_type' => Str::of(trim($request->disaster_type))->title(),
    //     ];

    //     try{
    //         $this->disaster->registerDisasterObject($disasterData);
    //         Alert::success('Disaster Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
    //     }catch(\Exception $e){
    //         Alert::error('Failed to Register Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
    //     }
            
    //     return back();
    // }

    public function updateDisaster(DisasterRequest $request, $disasterId){
        try{
            $this->disaster->updateDisasterObject($request, $disasterId);
            Alert::success('Disaster Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Update Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
        }
           
        return back();
    }

    public function removeDisaster($disasterId){
        try{
            $this->disaster->removeDisasterObject($disasterId);
            Alert::success('Disaster Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Deleted Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
        }
        
        return back();
    }
}