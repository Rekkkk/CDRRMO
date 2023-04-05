<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baranggay;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class BaranggayController extends Controller
{
    public function baranggayList(){
        $baranggayList = array("baranggay" => DB::table('baranggay')->orderBy('baranggay_id', 'asc')->simplePaginate(3));
        
        return $baranggayList;
    }

    public function registerBaranggay(Request $request){
    
        $validatedBaranggay = Validator::make($request->all(), [
            'baranggay_label' => 'required',
        ]);

        if($validatedBaranggay->passes()) {

            Baranggay::create([
                'baranggay_label' => $request->baranggay_label,
            ]);

            Alert::success('Baranggay Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/baranggay');
        }

        Alert::error('Failed to Register Baranggay', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/baranggay');
    }

    public function updateBaranggay(Request $request, $baranggay_id){
    
        $validatedBaranggay = Validator::make($request->all(), [
            'baranggay_label' => 'required',
        ]);

        if($validatedBaranggay->passes()){

            $baranggay_label = $request->input('baranggay_label');

            $updatedBaranggay = Baranggay::where('baranggay_id', $baranggay_id)->update([
                'baranggay_label' => $baranggay_label,
            ]);

            if($updatedBaranggay){
                Alert::success('Baranggay Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/baranggay');
            }
            else{
                Alert::error('Failed to Update Baranggay', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/baranggay');
            }
        }

        return redirect('cdrrmo/baranggay');
    }

    public function deleteBaranggay($baranggay_id){
    
        $deletedBaranggay = DB::table('baranggay')->where('baranggay_id', $baranggay_id)->delete();

        if($deletedBaranggay){
            Alert::success('Baranggay  Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/baranggay');
        }
        else{
            Alert::error('Failed to Deleted Baranggay', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/baranggay');
        }
    }
}
