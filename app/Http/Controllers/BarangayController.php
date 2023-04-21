<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangayRequest;
use App\Models\Barangay;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class BarangayController extends Controller{
    private $barangay;

    function __construct(){
        $this->barangay = new Barangay;
    }

    public function barangayList(){
        $barangayList = array("barangay" => DB::table('barangay')->orderBy('barangay_id', 'asc')->simplePaginate(6));
        
        return $barangayList;
    }

    public function registerBarangay(BarangayRequest $request){
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
            
        return back();
    }

    public function updateBarangay(BarangayRequest $request, $barangayId){
        try{
            $this->barangay->updateBarangayObject($request, $barangayId);
            Alert::success('Barangay Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
        }catch(\Exception $e){
            Alert::error('Failed to Update Barangay', 'Cabuyao City Disaster Risk Reduction Management Office');
        }

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