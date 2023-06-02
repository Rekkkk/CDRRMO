<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Guide;
use App\Models\Evacuee;
use App\Models\Disaster;
use App\Models\Guideline;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\EvacuationCenter;
use Illuminate\Support\Facades\Crypt;

class CdrrmoController extends Controller
{
    private $guideline;

    function __construct()
    {
        $this->guideline = new Guideline;
    }

    public function dashboard()
    {
        return view('userpage.dashboard');
    }

    public function eligtasGuideline()
    {
        $guideline = $this->guideline->displayGuideline();

        return view('userpage.guideline.eligtasGuideline', compact('guideline'));
    }

    public function guide($guidelineId)
    {
        $guide = Guide::where('guideline_id', Crypt::decryptString($guidelineId))->oldest()->get();

        $quiz = Quiz::where('guideline_id' , $guidelineId)->exists();

        return view('userpage.guideline.guide', compact('guide', 'quiz', 'guidelineId'));
    }

    public function quizMaker($guidelineId)
    {
        $quiz = Quiz::all()->where('guideline_id' , $guidelineId);
        return view('userpage.guideline.quizMaker', compact('guidelineId', 'quiz'));
    }

    public function disaster(Request $request)
    {
        $disaster = Disaster::all();

        if ($request->ajax()) {
            $data = Disaster::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->disaster_id . '" data-original-title="Edit" class="bg-slate-700 hover:bg-slate-900 py-1.5 btn-sm mr-2 text-white updateDisaster">Edit</a>';
                    $btn = $editBtn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->disaster_id . '" data-original-title="Remove" class="bg-red-700 hover:bg-red-900 py-1.5 btn-sm mr-2 text-white removeDisaster">Remove</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('userpage.disaster.disaster', compact('disaster'));
    }
    
    public function evacuationManage()
    {
        return view('userpage.evacuationCenter.evacuation');
    }

    public function evacuationCenter()
    {
        $evacuationCenter = EvacuationCenter::all();

        $initialMarkers = [
            [
                'position' => [
                    'lat' => 28.625485,
                    'lng' => 79.821091
                ],
                'label' => ['color' => 'white', 'text' => 'P1'],
                'draggable' => true
            ],
            [
                'position' => [
                    'lat' => 28.625293,
                    'lng' => 79.817926
                ],
                'label' => ['color' => 'white', 'text' => 'P2'],
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 28.625182,
                    'lng' => 79.81464
                ],
                'label' => ['color' => 'white', 'text' => 'P3'],
                'draggable' => true
            ]
        ];

        return view('userpage.evacuationCenter.evacuationCenter', ['evacuationCenter' => $evacuationCenter, 'initialMarkers' => $initialMarkers]);
    }

    public function statistics()
    {
        $typhoonMaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '1')->where('evacuee_gender', 'Male')->get();
        $typhoonFemaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '1')->where('evacuee_gender', 'Female')->get();
        $earthquakeMaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '2')->where('evacuee_gender', 'Male')->get();
        $earthquakeFemaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '2')->where('evacuee_gender', 'Female')->get();
        $roadAccidentMaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '3')->where('evacuee_gender', 'Male')->get();
        $roadAccidentFemaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '3')->where('evacuee_gender', 'Female')->get();
        $floodingMaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '4')->where('evacuee_gender', 'Male')->get();
        $floodingFemaleData = Evacuee::select('evacuee_gender')->where('disaster_id', '4')->where('evacuee_gender', 'Female')->get();

        return view('userpage.statistics.statistics', compact('typhoonMaleData', 'typhoonFemaleData', 'earthquakeMaleData', 'earthquakeFemaleData', 'roadAccidentMaleData', 'roadAccidentFemaleData', 'floodingMaleData', 'floodingFemaleData'));
    }

    public function reportAccident()
    {
        return view('userpage.reportAccident.reportAccident');
    }

    public function hotlineNumbers()
    {
        return view('userpage.hotlineNumbers.hotlineNumbers');
    }

    public function about()
    {
        return view('userpage.about.about');
    }
}
