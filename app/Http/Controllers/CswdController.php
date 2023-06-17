<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guide;
use App\Models\Evacuee;
use App\Models\Disaster;
use App\Models\Guideline;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use App\Models\EvacuationCenter;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CswdController extends Controller
{
    private $evacuee, $evacuation, $guideline, $guide;

    function __construct()
    {
        $this->evacuee = new Evacuee;
        $this->guideline = new Guideline();
        $this->guide = new Guide();
        $this->evacuation = new EvacuationCenter;
    }
    public function dashboard()
    {
        $activeEvacuation = $this->evacuation->isActive();
        $inActiveEvacuation = $this->evacuation->isInactive();

        $inEvacuationCenter = $this->evacuee->countEvacueeOnEvacuation();
        $isReturned = $this->evacuee->countEvacueeReturned();

        $typhoonMaleData = $this->evacuee->countEvacuee(1, 'Male');
        $typhoonFemaleData = $this->evacuee->countEvacuee(1, 'Female');
        $floodingMaleData = $this->evacuee->countEvacuee(2, 'Male');
        $floodingFemaleData = $this->evacuee->countEvacuee(2, 'Female');

        $typhoonData = $this->evacuee->countEvacueeWithDisablities(1);

        $typhoon_4Ps = intval($typhoonData[0]->{'4Ps'});
        $typhoon_PWD = intval($typhoonData[0]->PWD);
        $typhoon_pregnant = intval($typhoonData[0]->pregnant);
        $typhoon_lactating = intval($typhoonData[0]->lactating);
        $typhoon_student = intval($typhoonData[0]->student);
        $typhoon_working = intval($typhoonData[0]->working);

        $floodingData = $this->evacuee->countEvacueeWithDisablities(2);

        $flooding_4Ps = intval($floodingData[0]->{'4Ps'});
        $flooding_PWD = intval($floodingData[0]->PWD);
        $flooding_pregnant = intval($floodingData[0]->pregnant);
        $flooding_lactating = intval($floodingData[0]->lactating);
        $flooding_student = intval($floodingData[0]->student);
        $flooding_working = intval($floodingData[0]->working);

        return view('userpage.dashboard', compact(
            'activeEvacuation',
            'inActiveEvacuation',
            'inEvacuationCenter',
            'isReturned',
            'typhoonMaleData',
            'typhoonFemaleData',
            'floodingMaleData',
            'floodingFemaleData',
            'typhoon_4Ps',
            'typhoon_PWD',
            'typhoon_pregnant',
            'typhoon_lactating',
            'typhoon_student',
            'typhoon_working',
            'flooding_4Ps',
            'flooding_PWD',
            'flooding_pregnant',
            'flooding_lactating',
            'flooding_student',
            'flooding_working'
        ));
    }

    public function recordEvacuee()
    {
        $evacuationCenters = EvacuationCenter::all();
        $disasters = Disaster::all();
        return view('userpage.recordEvacuee', compact('evacuationCenters', 'disasters'));
    }
    public function recordEvacueeInfo(Request $request)
    {
        $validatedEvacueeForm = Validator::make($request->all(), [
            'house_hold_number' => 'required',
            'name' => 'required',
            'sex' => 'required',
            'age' => 'required',
            'barangay' => 'required',
            'disaster' => 'required',
            'evacuation_assigned' => 'required'
        ]);

        if ($validatedEvacueeForm->passes()) {

            $is4Ps = $request->has('fourps') ? 1 : 0;
            $isPWD = $request->has('pwd') ? 1 : 0;
            $isPregnant = $request->has('pregnant') ? 1 : 0;
            $isLactating = $request->has('lactating') ? 1 : 0;
            $isStudent = $request->has('student') ? 1 : 0;
            $isWorking = $request->has('working') ? 1 : 0;

            $evacueeObject = [
                'house_hold_number' => $request->house_hold_number,
                'name' => Str::ucfirst(trim($request->name)),
                'sex' => $request->sex,
                'age' => $request->age,
                '4Ps' => $is4Ps,
                'PWD' => $isPWD,
                'pregnant' => $isPregnant,
                'lactating' => $isLactating,
                'student' => $isStudent,
                'working' => $isWorking,
                'barangay' => $request->barangay,
                'date_entry' => Carbon::now()->toDayDateTimeString(),
                'disaster_id' => $request->disaster,
                'evacuation_assigned' => $request->evacuation_assigned
            ];

            try {
                $this->evacuee->recordEvacueeObject($evacueeObject);

                ActivityUserLog::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Registering Evacuee',
                    'date_time' => Carbon::now()->toDayDateTimeString()
                ]);

                return response()->json(['condition' => 1]);
            } catch (\Exception $e) {
                return response()->json(['condition' => 0]);
            }
        }

        return response()->json(['condition' => 0, 'error' => $validatedEvacueeForm->errors()->toArray()]);
    }

    public function eligtasGuideline()
    {
        $guideline = $this->guideline->retrieveAll();

        return view('userpage.guideline.eligtasGuideline', compact('guideline'));
    }

    public function guide($guidelineId)
    {
        $guide = $this->guide->retreiveAllGuide($guidelineId);

        return view('userpage.guideline.guide', compact('guide', 'guidelineId'));
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

    public function evacuationManage()
    {
        return view('userpage.evacuationCenter.evacuation');
    }

    public function disaster(Request $request)
    {
        $disaster = Disaster::all();

        if ($request->ajax()) {
            return DataTables::of($disaster)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="bg-slate-700 hover:bg-slate-900 py-1.5 btn-sm mr-2 text-white updateDisaster">Edit</a>';
                    $btn = $editBtn . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Remove" class="bg-red-700 hover:bg-red-900 py-1.5 btn-sm mr-2 text-white removeDisaster">Remove</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('userpage.disaster.disaster', compact('disaster'));
    }
}
