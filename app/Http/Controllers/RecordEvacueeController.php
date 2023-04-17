<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Baranggay;
use App\Models\Disaster;
use App\Models\EvacuationCenter;

class RecordEvacueeController extends Controller
{
    public function baranggayList(){
        $baranggayLists = Baranggay::all()->sortBy('baranggay_name');

        return $baranggayLists;
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
