<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Barangay;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class BarangayController extends Controller
{
    public function barangayList(){
        $barangayList = array("barangay" => DB::table('barangay')->orderBy('barangay_id', 'asc')->simplePaginate(6));
        
        return $barangayList;
    }

    public function registerBarangay(Request $request){
    
        $validatedBarangay = Validator::make($request->all(), [
            'barangay_name' => 'required',
            'barangay_location' => 'required',
            'barangay_contact' => 'required',
            'barangay_email' => 'required',
        ]);

        if($validatedBarangay->passes()) {

            Barangay::create([
                'barangay_name' => Str::ucfirst($request->barangay_name),
                'barangay_location' => Str::ucfirst($request->barangay_location),
                'barangay_contact_number' => $request->barangay_contact,
                'barangay_email_address' => $request->barangay_email,
            ]);

            Alert::success('Barangay Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/barangay');
        }

        Alert::error('Failed to Register Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/barangay');
    }

    public function updateBarangay(Request $request, $barangay_id){
    
        $validatedBarangay = Validator::make($request->all(), [
            'barangay_name' => 'required',
            'barangay_location' => 'required',
            'barangay_contact' => 'required',
            'barangay_email' => 'required',
        ]);

        if($validatedBarangay->passes()){

            $barangay_name = $request->input('baranggay_name');
            $barangay_location = $request->input('baranggay_location');
            $barangay_contact = $request->input('baranggay_contact');
            $barangay_email = $request->input('baranggay_email');

            $updatedBarangay = Barangay::where('baranggay_id', $barangay_id)->update([
                'barangay_name' => Str::ucfirst($barangay_name),
                'barangay_location' => Str::ucfirst($barangay_location),
                'barangay_contact_number' => $barangay_contact,
                'barangay_email_address' => $barangay_email,
            ]);

            if($updatedBarangay){
                Alert::success('Barangay Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/barangay');
            }
            else{
                Alert::error('Failed to Update Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/barangay');
            }
        }

        return redirect('cdrrmo/baranggay');
    }

    public function removeBarangay($barangay_id){
    
        $deletedBarangay = DB::table('barangay')->where('barangay_id', $barangay_id)->delete();

        if($deletedBarangay){
            Alert::success('Barangay Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/barangay');
        }
        else{
            Alert::error('Failed to Deleted Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/barangay');
        }
    }
}
