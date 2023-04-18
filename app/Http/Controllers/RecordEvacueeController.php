<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\Disaster;
use App\Models\EvacuationCenter;

class RecordEvacueeController extends Controller
{
    public function barangayList(){
        $barangayLists = Barangay::all()->sortBy('barangay_name');

        return $barangayLists;
    }

    public function evacuationCenterList(){
        $evacuationCenterLists = EvacuationCenter::all()->sortBy('evacuation_name');

        return $evacuationCenterLists;
    }

    public function disasterList(){
        $disasterLists = Disaster::all()->sortBy('disaster_name');

        return $disasterLists;
    }
}
