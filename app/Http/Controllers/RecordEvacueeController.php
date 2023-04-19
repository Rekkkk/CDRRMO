<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\Disaster;
use App\Models\EvacuationCenter;
use App\Models\Evacuee;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RecordEvacueeController extends Controller
{
    public function barangayList()
    {
        $barangayLists = Barangay::all()->sortBy('barangay_name');

        return $barangayLists;
    }

    public function evacuationCenterList()
    {
        $evacuationCenterLists = EvacuationCenter::all()->sortBy('evacuation_name');

        return $evacuationCenterLists;
    }

    public function disasterList()
    {
        $disasterLists = Disaster::all()->sortBy('disaster_name');

        return $disasterLists;
    }

    public function recordEvacueeInfo(Request $request)
    {
        $validatedInformation = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'middle_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'last_name' => 'required|regex:/^[a-zA-Z]+$/u',
            'contact_number' => 'required|numeric|digits:11',
            'age' => 'required|numeric',
            'gender' => 'required',
            'address' => 'required',
            'barangay' => 'required',
            'evacuation_center' => 'required',
            'disaster' => 'required',
        ]);

        if ($validatedInformation->passes()) {
            Evacuee::create([
                'evacuee_first_name' => Str::ucfirst($request->first_name),
                'evacuee_last_name' => Str::ucfirst($request->last_name),
                'evacuee_middle_name' => Str::ucfirst($request->middle_name),
                'evacuee_contact_number' => $request->contact_number,
                'evacuee_age' => $request->age,
                'evacuee_gender' => $request->gender,
                'evacuee_address' => $request->address,
                'baranggay_id' => $request->baranggay,
                'disaster_id' => $request->disaster,
                'evacuation_assigned' => $request->evacuation_center,
            ]);

            Alert::success('Evacuee Information Recorded Successfully');

            return redirect('cdrrmo/recordEvacuee');
        } else {
            Alert::error('Failed to Record Evacuee Information');

            return back()->withErrors($validatedInformation)->withInput();
        }
    }
}
