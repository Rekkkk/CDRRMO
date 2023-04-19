<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Disaster;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DisasterController extends Controller
{
    private $disaster;

    public function __construct() {
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

            $this->disaster->registerDisasterObject($disasterData);

            Alert::success('Disaster Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/disaster');
        }

        Alert::error('Failed to Register Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/disaster');
    }

    public function updateDisaster(Request $request, $disaster_id){
    
        $validatedDisaster = Validator::make($request->all(), [
            'disaster_name' => 'required',
        ]);

        if($validatedDisaster){

            $this->disaster->updateDisasterObject($request, $disaster_id);

            Alert::success('Disaster Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/disaster');
        }

        Alert::error('Failed to Update Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/disaster');
    }

    public function removeDisaster($disaster_id){
    
        $this->disaster->removeDisasterObject($disaster_id);

        Alert::success('Disaster Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/disaster');
    }
}