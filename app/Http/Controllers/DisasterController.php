<?php

namespace App\Http\Controllers;

use App\Models\Disaster;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DisasterController extends Controller{
    private $disaster;

    function __construct() {
        $this->disaster = new Disaster;
    }

    public function disasterList(){
        $disaster = $this->disaster->displayDisasterObject();

        return compact('disaster');
    }

    public function registerDisaster(Request $request){
        $validatedDisaster = Validator::make($request->all(), [
            'disaster_name' => 'required',
        ]);
        
        if($validatedDisaster->passes()) {
            
            $disasterData = [
                'disaster_name' => Str::of(trim($request->disaster_name))->title(),
            ];

            try{
                $this->disaster->registerDisasterObject($disasterData);
                Alert::success('Disaster Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            }catch(\Exception $e){
                Alert::error('Failed to Register Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
            }
            
            return back();
        }

        Alert::error('Failed to Register Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
        return back()->withErrors($validatedDisaster)->withInput();
    }

    public function updateDisaster(Request $request, $disasterId){
        $validatedDisaster = Validator::make($request->all(), [
            'disaster_name' => 'required',
        ]);

        if($validatedDisaster){

            try{
                $this->disaster->updateDisasterObject($request, $disasterId);
                Alert::success('Disaster Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            }catch(\Exception $e){
                Alert::error('Failed to Update Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
            }
           
            return back();
        }

        Alert::error('Failed to Update Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
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