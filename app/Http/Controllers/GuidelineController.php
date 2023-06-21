<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Guideline;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class GuidelineController extends Controller
{
    private $guideline, $guide, $logActivity;

    function __construct()
    {
        $this->guide = new Guide;
        $this->guideline = new Guideline;
        $this->logActivity = new ActivityUserLog;
    }

    public function addGuideline(Request $request)
    {
        $validatedGuideline = Validator::make($request->all(), [
            'type' => 'required'
        ]);

        if ($validatedGuideline->passes()) {
            $guidelineData = [
                'type' => Str::upper(trim("$request->type Guideline"))
            ];

            try {
                $this->guideline->create($guidelineData);
                $this->logActivity->generateLog('Registering Guideline');

                return response()->json(['condition' => 1]);
            } catch (\Exception $e) {
                return response()->json(['condition' => 0]);
            }
        }

        return response()->json(['condition' => 0, 'error' => $validatedGuideline->errors()->toArray()]);
    }

    public function updateGuideline(Request $request, $guidelineId)
    {
        $validatedGuideline = Validator::make($request->all(), [
            'type' => 'required'
        ]);

        if ($validatedGuideline->passes()) {
            $guidelineData = [
                'type' => Str::upper(trim($request->input('type')))
            ];

            try {
                $this->guideline->where('id', $guidelineId)->update($guidelineData);
                $this->logActivity->generateLog('Updating Guideline');

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
            $this->guideline->where('id', Crypt::decryptString($guidelineId))->delete();
            $this->logActivity->generateLog('Deleting Guideline');

            Alert::success(config('app.name'), 'Guideline Deleted Successfully.');
        } catch (\Exception $e) {
            Alert::error(config('app.name'), 'Failed to Add Guideline.');
        }

        return back();
    }

    public function addGuide(Request $request, $guidelineId)
    {
        $validatedGuide = Validator::make($request->all(), [
            'label' => 'required',
            'content' => 'required'
        ]);

        if ($validatedGuide->passes()) {
            $guideData = [
                'label' => Str::of(trim($request->label))->title(),
                'content' => Str::ucFirst(trim($request->content)),
                'guideline_id' => Crypt::decryptString($guidelineId)
            ];

            try {
                $this->guide->create($guideData);
                $this->logActivity->generateLog('Registering Guide');
    
                return response()->json(['condition' => 1]);
            } catch (\Exception $e) {
                return response()->json(['condition' => 0]);
            }
        }

        return response()->json(['condition' => 0, 'error' => $validatedGuide->errors()->toArray()]);
    }

    public function updateGuide(Request $request, $guideId)
    {
        $validatedGuide = Validator::make($request->all(), [
            'label' => 'required',
            'content' => 'required'
        ]);

        if ($validatedGuide->passes()) {
            $guideData = [
                'label' => Str::of(trim($request->input('label')))->title(),
                'content' => Str::ucfirst(trim($request->input('content')))
            ];

            try {
                $this->guide->where('id', $guideId)->update($guideData);
                $this->logActivity->generateLog('Updating Guide');

                Alert::success(config('app.name'), 'Guide Successfully Updated.');
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Update Guide.');
            }
        }
        return back();
    }

    public function removeGuide($guideId)
    {
        try {
            $this->guide->where('id', $guideId)->delete();
            $this->logActivity->generateLog('Removing Guide');

            Alert::success(config('app.name'), 'Guide Removed Successfully.');
        } catch (\Exception $e) {
            Alert::error(config('app.name'), 'Failed to Remove Guide.');
        }

        return back();
    }
}
