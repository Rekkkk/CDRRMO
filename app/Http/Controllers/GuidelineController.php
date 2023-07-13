<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Guideline;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class GuidelineController extends Controller
{
    private $guide, $guideline, $logActivity;

    function __construct()
    {
        $this->guide = new Guide;
        $this->guideline = new Guideline;
        $this->logActivity = new ActivityUserLog;
    }

    public function eligtasGuideline()
    {
        $guideline = "";

        if (!auth()->check()) {
            $guideline = $this->guideline->all();

            return view('userpage.guideline.eligtasGuideline', compact('guideline'));
        }

        if (auth()->user()->organization === "CDRRMO" && auth()->check()) {
            $guideline = $this->guideline->where('organization', "CDRRMO")->where('is_archive', 0)->get();
        } else {
            $guideline = $this->guideline->where('organization', "CSWD")->where('is_archive', 0)->get();
        }

        return view('userpage.guideline.eligtasGuideline', compact('guideline'));
    }

    public function addGuideline(Request $request)
    {
        $validatedGuideline = Validator::make($request->all(), [
            'type' => 'unique:guideline,type'
        ]);

        if ($validatedGuideline->passes()) {
            try {
                $this->guideline->create([
                    'type' => Str::lower(trim("$request->type guideline")),
                    'organization' => auth()->user()->organization,
                    'is_archive' => 0
                ]);
                $this->logActivity->generateLog('Registering Guideline');

                return response()->json(['status' => 'success', 'message' => 'Guideline successfully added, Please wait...']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
            }
        }

        return response()->json(['status' => 'warning', 'message' => 'Guideline is existing.']);
    }

    public function updateGuideline(Request $request, $guidelineId)
    {
        $validatedGuideline = Validator::make($request->all(), [
            'type' => 'unique:guideline,type'
        ]);

        if ($validatedGuideline->passes()) {
            try {
                $this->guideline->find(Crypt::decryptString($guidelineId))->update([
                    'type' => Str::lower(trim($request->type))
                ]);
                $this->logActivity->generateLog('Updating Guideline');

                return response()->json(['status' => 'success', 'message' => 'Guideline successfully updated, Please wait...']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
            }
        }

        return response()->json(['status' => 'warning', 'message' => 'Guideline is existing.']);
    }

    public function archiveGuideline($guidelineId)
    {
        try {
            $this->guideline->find(Crypt::decryptString($guidelineId))->update([
                'is_archive' => 1
            ]);
            $this->logActivity->generateLog('Archiving Guideline');

            return response()->json(['status' => 'success', 'message' => 'Guideline removed successfully, Please wait...']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function guide($guidelineId)
    {
        $guide = $this->guide->where('guideline_id', Crypt::decryptString($guidelineId))->where('is_archive', 0)->get();

        return view('userpage.guideline.guide', compact('guide', 'guidelineId'));
    }

    public function addGuide(Request $request, $guidelineId)
    {
        $validatedGuide = Validator::make($request->all(), [
            'label' => 'unique:guide,label'
        ]);

        if ($validatedGuide->passes()) {
            try {
                $this->guide->create([
                    'label' => Str::lower(trim($request->label)),
                    'content' => Str::ucFirst(trim($request->content)),
                    'guideline_id' => Crypt::decryptString($guidelineId),
                    'is_archive' => 0
                ]);
                $this->logActivity->generateLog('Registering Guide');

                return response()->json(['status' => 'success', 'message' => 'Guide successfully added, Please wait...']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
            }
        }

        return response()->json(['status' => 'warning', 'message' => 'Guide is existing.']);
    }

    public function updateGuide(Request $request, $guideId)
    {
        $validatedGuide = Validator::make($request->all(), [
            'label' => 'unique:guideline,type'
        ]);

        if ($validatedGuide->passes()) {
            try {
                $this->guide->find($guideId)->update([
                    'label' => Str::lower(trim($request->label)),
                    'content' => Str::ucfirst(trim($request->content))
                ]);
                $this->logActivity->generateLog('Updating Guide');

                return response()->json(['status' => 'success', 'message' => 'Guide successfully updated, Please wait...']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
            }
        }

        return response()->json(['status' => 'warning', 'message' => 'Guide is existing.']);
    }

    public function archiveGuide($guideId)
    {
        try {
            $this->guide->find($guideId)->update([
                'is_archive' => 1
            ]);
            $this->logActivity->generateLog('Archiving Guide');

            return response()->json(['status' => 'success', 'message' => 'Guide archived successfully, Please wait...']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
