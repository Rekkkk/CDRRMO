<?php

namespace App\Http\Controllers;

use App\Models\EvacuationCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class EvacuationCenterController extends Controller
{
    public function evacuationCenterList(){
        $EvacuationList = array("evacuation" => DB::table('evacuation_center')->orderBy('evacuation_id', 'asc')->simplePaginate(4));

        return $EvacuationList;
    }

    public function registerEvacuation(Request $request){
        $validatedEvacuation = Validator::make($request->all(), [
            'evacuation_name' => 'required',
            'evacuation_contact' => 'required',
            'evacuation_location' => 'required',
        ]);

        if($validatedEvacuation->passes()) {

            EvacuationCenter::create([
                'evacuation_name' => $request->evacuation_name,
                'evacuation_contact' => $request->evacuation_contact,
                'evacuation_location' => $request->evacuation_location,
            ]);

            Alert::success('Evacuation Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/evacuationManage');
        }

        Alert::error('Failed to Register Evacuation', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/evacuationManage');
    }

    public function updateEvacuation(Request $request, $evacuation_id){
        $validatedEvacuation = Validator::make($request->all(), [
            'evacuation_name' => 'required',
            'evacuation_contact' => 'required',
            'evacuation_location' => 'required',
        ]);

        if($validatedEvacuation->passes()){

            $evacuation_name = $request->input('evacuation_name');
            $evacuation_contact = $request->input('evacuation_contact');
            $evacuation_location = $request->input('evacuation_location');

            $updatedEvacuation = EvacuationCenter::where('evacuation_id', $evacuation_id)->update([
                'evacuation_name' => $evacuation_name,
                'evacuation_contact' => $evacuation_contact,
                'evacuation_location' => $evacuation_location,
            ]);

            if($updatedEvacuation){
                Alert::success('Evacuation Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/evacuationManage');
            }
            else{
                Alert::error('Failed to Update Evacuation', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/evacuationManage');
            }
        }

        return redirect('cdrrmo/evacuationManage');
    }

    public function deleteEvacuation($evacuation_id){
        $deletedEvacuation = DB::table('evacuation_center')->where('evacuation_id', $evacuation_id)->delete();

        if($deletedEvacuation){
            Alert::success('Evacuation Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/evacuationManage');
        }
        else{
            Alert::error('Failed to Deleted Evacuation', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/evacuationManage');
        }
    }
}
