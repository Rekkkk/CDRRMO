<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Baranggay;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class BaranggayController extends Controller
{
    public function baranggayList(){
        $baranggayList = array("baranggay" => DB::table('baranggay')->orderBy('baranggay_id', 'asc')->simplePaginate(6));
        
        return $baranggayList;
    }

    public function registerBaranggay(Request $request){
    
        $validatedBaranggay = Validator::make($request->all(), [
            'baranggay_name' => 'required',
            'baranggay_location' => 'required',
            'baranggay_contact' => 'required',
            'baranggay_email' => 'required',
        ]);

        if($validatedBaranggay->passes()) {

            Baranggay::create([
                'baranggay_name' => Str::ucfirst($request->baranggay_name),
                'baranggay_location' => Str::ucfirst($request->baranggay_location),
                'baranggay_contact_number' => $request->baranggay_contact,
                'baranggay_email_address' => $request->baranggay_email,
            ]);

            Alert::success('Baranggay Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/baranggay');
        }

        Alert::error('Failed to Register Baranggay', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/baranggay');
    }

    public function updateBaranggay(Request $request, $baranggay_id){
    
        $validatedBaranggay = Validator::make($request->all(), [
            'baranggay_name' => 'required',
            'baranggay_location' => 'required',
            'baranggay_contact' => 'required',
            'baranggay_email' => 'required',
        ]);

        if($validatedBaranggay->passes()){

            $baranggay_name = $request->input('baranggay_name');
            $baranggay_location = $request->input('baranggay_location');
            $baranggay_contact = $request->input('baranggay_contact');
            $baranggay_email = $request->input('baranggay_email');

            $updatedBaranggay = Baranggay::where('baranggay_id', $baranggay_id)->update([
                'baranggay_name' => Str::ucfirst($baranggay_name),
                'baranggay_location' => Str::ucfirst($baranggay_location),
                'baranggay_contact_number' => $baranggay_contact,
                'baranggay_email_address' => $baranggay_email,
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
