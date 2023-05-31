<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guide;
use App\Models\Guideline;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class GuidelineController extends Controller
{
    private $guideline, $guide;

    function __construct()
    {
        $this->guideline = new Guideline;
        $this->guide = new Guide;
    }

    public function addGuideline(Request $request)
    {
        $validatedGuideline = Validator::make($request->all(), [
            'guideline_description' => 'required'
        ]);

        if ($validatedGuideline->passes()) {

            $guidelineData = [
                'guideline_description' => Str::upper(trim("E-LIGTAS $request->guideline_description Guideline"))
            ];

            try {
                $this->guideline->registerGuidelineObject($guidelineData);
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Add Guideline.');
            }

            ActivityUserLog::create([
                'email' => Auth::user()->email,
                'user_role' => Auth::user()->user_role,
                'role_name' => Auth::user()->role_name,
                'activity' => 'Registering Guideline',
                'date_time' => Carbon::now()->toDayDateTimeString()
            ]);

            return response()->json(['condition' => 1]);
        }

        return response()->json(['condition' => 0, 'error' => $validatedGuideline->errors()->toArray()]);
    }

    public function updateGuideline(Request $request, $guidelineId)
    {

        $validatedGuideline = Validator::make($request->all(), [
            'guideline_description' => 'required'
        ]);

        if ($validatedGuideline->passes()) {

            try {
                $this->guideline->updateGuidelineObject($request, $guidelineId);

                ActivityUserLog::create([
                    'email' => Auth::user()->email,
                    'user_role' => Auth::user()->user_role,
                    'role_name' => Auth::user()->role_name,
                    'activity' => 'Updating Guideline',
                    'date_time' => Carbon::now()->toDayDateTimeString()
                ]);

                Alert::success(config('app.name'), 'Guideline Successfully Updated.');
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Add Guideline.');
            }

            return back();
        }

        Alert::error(config('app.name'), 'Failed to Add Guideline.');
        return back();
    }

    public function removeGuideline($guidelineId)
    {
        try {
            $this->guideline->removeGuidelineObject(Crypt::decryptString($guidelineId));

            ActivityUserLog::create([
                'email' => Auth::user()->email,
                'user_role' => Auth::user()->user_role,
                'role_name' => Auth::user()->role_name,
                'activity' => 'Deleting Guideline',
                'date_time' => Carbon::now()->toDayDateTimeString()
            ]);

            Alert::success(config('app.name'), 'Guideline Deleted Successfully.');
        } catch (\Exception $e) {
            Alert::error(config('app.name'), 'Failed to Add Guideline.');
        }

        return back();
    }

    public function addGuide(Request $request, $guidelineId)
    {
        $validatedGuide = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required'
        ]);

        if ($validatedGuide->passes()) {
            $guideData = [
                'guide_description' => Str::of(trim($request->guide_description))->title(),
                'guide_content' => Str::ucFirst(trim($request->guide_content)),
                'guideline_id' => Crypt::decryptString($guidelineId),
            ];

            try {
                $this->guide->registerGuideObject($guideData);
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Add Guide.');
            }

            ActivityUserLog::create([
                'email' => Auth::user()->email,
                'user_role' => Auth::user()->user_role,
                'role_name' => Auth::user()->role_name,
                'activity' => 'Registering Guide',
                'date_time' => Carbon::now()->toDayDateTimeString()
            ]);

            return response()->json(['condition' => 1]);
        }

        return response()->json(['condition' => 0, 'error' => $validatedGuide->errors()->toArray()]);
    }

    public function updateGuide(Request $request, $guideId)
    {
        $validatedGuide = Validator::make($request->all(), [
            'guide_description' => 'required',
            'guide_content' => 'required'
        ]);

        if ($validatedGuide->passes()) {
            try {
                $this->guide->updateGuideObject($request, $guideId);

                ActivityUserLog::create([
                    'email' => Auth::user()->email,
                    'user_role' => Auth::user()->user_role,
                    'role_name' => Auth::user()->role_name,
                    'activity' => 'Updating Guide',
                    'date_time' => Carbon::now()->toDayDateTimeString()
                ]);
                Alert::success(config('app.name'), 'Guide Successfully Updated.');
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Update Guide.');
            }

            return back();
        }
        return back();
    }

    public function removeGuide($guideId)
    {
        try {
            $this->guide->removeGuideObject($guideId);

            ActivityUserLog::create([
                'email' => Auth::user()->email,
                'user_role' => Auth::user()->user_role,
                'role_name' => Auth::user()->role_name,
                'activity' => 'Removing Guide',
                'date_time' => Carbon::now()->toDayDateTimeString()
            ]);
            Alert::success(config('app.name'), 'Guide Removed Successfully.');
        } catch (\Exception $e) {
            Alert::error(config('app.name'), 'Failed to Remove Guide.');
        }

        return back();
    }
}
