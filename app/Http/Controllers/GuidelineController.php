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

        if (auth()->user()->organization == "CDRRMO") {
            $guideline = $this->guideline->where('organization', "CDRRMO")->where('is_archive', 0)->get();
        } else {
            $guideline = $this->guideline->where('organization', "CSWD")->where('is_archive', 0)->get();
        }

        return view('userpage.guideline.eligtasGuideline', compact('guideline'));
    }

    public function createGuideline(Request $request)
    {
        $guidelineValidation = Validator::make($request->all(), [
            'type' => 'required|unique:guideline,type',
            'label.*' => 'required',
            'content.*' => 'required'
        ]);

        if ($guidelineValidation->fails())
            return response(['status' => 'warning', 'message' => $guidelineValidation->errors()->first()]);

        $guideline = $this->guideline->create([
            'type' => Str::lower(trim("$request->type guideline")),
            'organization' => auth()->user()->organization,
            'is_archive' => 0
        ]);
        $this->logActivity->generateLog('Registering Guideline');

        $labels = $request->input('label');
        $contents = $request->input('content');
        $guidePhotos = $request->file('guidePhoto');

        foreach ($labels as $count => $label) {
            $guide = $this->guide->create([
                'label' => $label,
                'content' => $contents[$count],
                'guideline_id' => $guideline->id,
                'is_archive' => 0
            ]);

            if (isset($guidePhotos[$count])) {
                $reportPhotoPath =  $guidePhotos[$count]->store();
                $guidePhotos[$count]->move(public_path('guide_photo'), $reportPhotoPath);
                $guide->guide_photo = $reportPhotoPath;
                $guide->save();
            }
        }

        return response()->json();
    }

    public function updateGuideline(Request $request, $guidelineId)
    {
        $guidelineValidation = Validator::make($request->all(), [
            'type' => 'required',
            'label.*' => 'required',
            'content.*' => 'required'
        ]);

        if ($guidelineValidation->fails())
            return response(['status' => 'warning', 'message' => $guidelineValidation->errors()->first()]);

        $guidelineId = Crypt::decryptString($guidelineId);
        $this->guideline->find($guidelineId)->update([
            'type' => Str::lower(trim($request->type))
        ]);
        $this->logActivity->generateLog('Updating Guideline');

        $labels = $request->input('label');
        $contents = $request->input('content');
        $guidePhotos = $request->file('guidePhoto');

        foreach ($labels as $count => $label) {
            $guide = $this->guide->create([
                'label' => $label,
                'content' => $contents[$count],
                'guideline_id' => $guidelineId,
                'is_archive' => 0
            ]);

            if (isset($guidePhotos[$count])) {
                $reportPhotoPath =  $guidePhotos[$count]->store();
                $guidePhotos[$count]->move(public_path('guide_photo'), $reportPhotoPath);
                $guide->guide_photo = $reportPhotoPath;
                $guide->save();
            }
        }

        return response()->json();
    }

    public function removeGuideline($guidelineId)
    {
        $this->guideline->find(Crypt::decryptString($guidelineId))->update([
            'is_archive' => 1
        ]);
        $this->logActivity->generateLog('Removing Guideline');
        return response()->json();
    }

    public function guide($guidelineId)
    {
        $guide = $this->guide->where('guideline_id', Crypt::decryptString($guidelineId))->where('is_archive', 0)->get();
        return view('userpage.guideline.guide', compact('guide', 'guidelineId'));
    }

    // public function createGuide(Request $request, $guidelineId)
    // {
    //     $guideValidation = Validator::make($request->all(), [
    //         'label' => 'required|unique:guide,label'
    //     ]);

    //     if ($guideValidation->fails())
    //         return response(['status' => 'warning', 'message' => $guideValidation->errors()->first()]);

    //     $this->guide->create([
    //         'label' => Str::of(trim($request->label))->title(),
    //         'content' => Str::ucFirst(trim($request->content)),
    //         'guideline_id' => Crypt::decryptString($guidelineId),
    //         'is_archive' => 0
    //     ]);
    //     $this->logActivity->generateLog('Creating Guide');
    //     return response()->json();
    // }

    public function updateGuide(Request $request, $guideId)
    {
        $guideValidation = Validator::make($request->all(), [
            'label' => 'required|unique:guideline,type',
            'content' => 'required'
        ]);

        if ($guideValidation->fails())
            return response(['status' => 'warning', 'message' => $guideValidation->errors()->first()]);

        $this->guide->find($guideId)->update([
            'label' => Str::of(trim($request->label))->title(),
            'content' => Str::ucfirst(trim($request->content))
        ]);
        $this->logActivity->generateLog('Updating Guide');
        return response()->json();
    }

    public function removeGuide($guideId)
    {
        $this->guide->find($guideId)->update([
            'is_archive' => 1
        ]);
        $this->logActivity->generateLog('Removing Guide');
        return response()->json();
    }
}
