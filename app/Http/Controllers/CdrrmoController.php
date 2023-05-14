<?php

namespace App\Http\Controllers;

use App\Models\ActivityUserLog;
use App\Models\Quiz;
use App\Models\Guide;
use App\Models\Guideline;
use App\Models\Disaster;
use Illuminate\Http\Request;
use App\Models\EvacuationCenter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CdrrmoController extends Controller
{
    private $guideline;
    private $disaster;

    function __construct()
    {
        $this->guideline = new Guideline;
        $this->disaster = new Disaster;
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
        $guide = Guide::where('guideline_id', Crypt::decryptString($guidelineId))->orderBy('guide_id', 'asc')->get();

        $quiz = Quiz::where('guideline_id', $guidelineId)->get();

        return view('userpage.guideline.guide', compact('guide', 'quiz'))->with('guidelineId', $guidelineId);
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

    public function barangay()
    {
        return view('userpage.barangay.barangay');
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
        $typhoonMaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '1')->where('evacuee_gender', 'Male')->get();
        $typhoonFemaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '1')->where('evacuee_gender', 'Female')->get();
        $earthquakeMaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '2')->where('evacuee_gender', 'Male')->get();
        $earthquakeFemaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '2')->where('evacuee_gender', 'Female')->get();
        $roadAccidentMaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '3')->where('evacuee_gender', 'Male')->get();
        $roadAccidentFemaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '3')->where('evacuee_gender', 'Female')->get();
        $floodingMaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '4')->where('evacuee_gender', 'Male')->get();
        $floodingFemaleData = DB::table('evacuee')->select('evacuee_gender')->where('disaster_id', '4')->where('evacuee_gender', 'Female')->get();

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

    public function logout(Request $request)
    {
        $currentDate = Carbon::now();
        $todayDate = $currentDate->toDayDateTimeString();

        ActivityUserLog::create([
            'user_id' => Auth::user()->id,
            'email' => Auth::user()->email,
            'user_role' => Auth::user()->user_role,
            'role_name' => Auth::user()->role_name,
            'activity' => 'Logged Out',
            'date_time' => $todayDate,
        ]);
        
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'Successfully Logout Admin Panel');
    }
}
