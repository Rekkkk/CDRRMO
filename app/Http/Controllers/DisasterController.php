<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Disaster;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DisasterController extends Controller
{

    public function disasterList(){
        $disasterList = array("disaster" => DB::table('disaster')->orderBy('disaster_id', 'asc')->simplePaginate(3));

        return $disasterList;
    }

    public function registerDisaster(Request $request){
    
        $validatedDisaster = Validator::make($request->all(), [
            'disaster_name' => 'required',
        ]);

        if($validatedDisaster->passes()) {

            Disaster::create([
                'disaster_name' => Str::of(trim($request->disaster_name))->title(),
            ]);

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

        if($validatedDisaster->passes()){

            $updatedDisaster = Disaster::where('disaster_id', $disaster_id)->update([
                'disaster_name' => Str::ucfirst(trim($request->input('disaster_name'))),
            ]);

            if($updatedDisaster){
                Alert::success('Disaster Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/disaster');
            }
            else{
                Alert::error('Failed to Update Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/disaster');
            }
        }

        return redirect('cdrrmo/disaster');
    }

    public function removeDisaster($disaster_id){
    
        $deletedDisaster = DB::table('disaster')->where('disaster_id', $disaster_id)->delete();

        if($deletedDisaster){
            Alert::success('Disaster Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/disaster');
        }
        else{
            Alert::error('Failed to Deleted Disaster', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/disaster');
        }
    }
}
