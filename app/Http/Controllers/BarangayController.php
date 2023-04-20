<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class BarangayController extends Controller{
    private $barangay;

    function __construct(){
        $this->barangay = new Barangay;
    }

    public function barangayList(){
        $barangayList = array("barangay" => DB::table('barangay')->orderBy('barangay_id', 'asc')->simplePaginate(6));
        
        return $barangayList;
    }

    public function registerBarangay(Request $request){
        $validatedBarangay = Validator::make($request->all(), [
            'barangay_name' => 'required',
            'barangay_location' => 'required',
            'barangay_contact' => 'required|numeric|digits:11',
            'barangay_email' => 'required|email:rfc,dns',
        ]);

        if($validatedBarangay->passes()) {

            $barangayData = [
                'barangay_name' => Str::ucfirst(trim($request->barangay_name)),
                'barangay_location' => Str::ucfirst(trim($request->barangay_location)),
                'barangay_contact_number' => trim($request->barangay_contact),
                'barangay_email_address' => trim($request->barangay_email),
            ];

            try{
                $this->barangay->registerBarangayObject($barangayData);
                Alert::success('Barangay Registered Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            }catch(\Exception $e){
                Alert::error('Failed to Register Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
            }
            
            return back()->withErrors($validatedBarangay)->withInput();
        }

        Alert::error('Failed to Register Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
        return back()->withErrors($validatedBarangay)->withInput();
    }

    public function updateBarangay(Request $request, $barangayId){
        $validatedBarangay = Validator::make($request->all(), [
            'barangay_name' => 'required',
            'barangay_location' => 'required',
            'barangay_contact' => 'required|numeric|digits:11',
            'barangay_email' => 'required|email:rfc,dns',
        ]);

        if($validatedBarangay->passes()){

            try{
                $this->barangay->updateBarangayObject($request, $barangayId);
                Alert::success('Barangay Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            }catch(\Exception $e){
                Alert::error('Failed to Update Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
            }

            return back();
        }

        Alert::error('Failed to Update Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
        return back();
    }

    public function removeBarangay($barangayId){
        try{
            $this->barangay->removeBarangayObject($barangayId);
            Alert::success('Barangay Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Delete Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
        }

        return back();
    }
}