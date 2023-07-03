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
    private $guide, $guideline, $logActivity;

    function __construct()
    {
        $this->guide = new Guide;
        $this->guideline = new Guideline;
        $this->logActivity = new ActivityUserLog;
    }

    public function eligtasGuideline()
    {
        if (!auth()->check()) {
            $guideline = $this->guideline->all();

            return view('userpage.guideline.eligtasGuideline', compact('guideline'));
        }

        $author = auth()->user();

        $organization = $this->guideline->where('organization', $author->organization);

        $guideline = $organization->when($author->position === "Secretary", function ($query) use ($author) {
            return $query->where('author', $author->id);
        })->get();

        return view('userpage.guideline.eligtasGuideline', compact('guideline'));
    }

    public function addGuideline(Request $request)
    {
        $validatedGuideline = Validator::make($request->all(), [
            'type' => ['required', 'unique:guideline,type']
        ]);

        if ($validatedGuideline->passes()) {
            try {
                $this->guideline->create([
                    'type' => Str::lower(trim("$request->type Guideline")),
                    'organization' => auth()->user()->organization,
                    'author' => auth()->user()->id
                ]);
                $this->logActivity->generateLog('Registering Guideline');

                return response()->json(['status' => 1]);
            } catch (\Exception $e) {
                return response()->json(['status' => 0]);
            }
        }

        return response()->json(['status' => 0, 'error' => $validatedGuideline->errors()->toArray()]);
    }

    public function updateGuideline(Request $request, $guidelineId)
    {
        $validatedGuideline = Validator::make($request->all(), [
            'type' => 'required'
        ]);

        if ($validatedGuideline->passes()) {
            try {
                $this->guideline->find($guidelineId)->update([
                    'type' => Str::lower(trim($request->type))
                ]);
                $this->logActivity->generateLog('Updating Guideline');

                Alert::success(config('app.name'), 'Guideline Successfully Updated.');
            } catch (\Exception $e) {
                Alert::error(config('app.name'), 'Failed to Update Guideline.');
            }

            return back();
        }

        Alert::error(config('app.name'), 'Failed to Update Guideline.');
        return back();
    }

    public function removeGuideline($guidelineId)
    {
        try {
            $this->guideline->find(Crypt::decryptString($guidelineId))->delete();
            $this->logActivity->generateLog('Deleting Guideline');

            Alert::success(config('app.name'), 'Guideline Removed Successfully.');
        } catch (\Exception $e) {
            Alert::error(config('app.name'), 'Failed to Remove Guideline.');
        }

        return back();
    }

    public function guide($guidelineId)
    {
        $guide = $this->guide->where('guideline_id', Crypt::decryptString($guidelineId))->get();

        return view('userpage.guideline.guide', compact('guide', 'guidelineId'));
    }

    public function addGuide(Request $request, $guidelineId)
    {
        try {
            $this->guide->create([
                'label' => Str::lower(trim($request->label)),
                'content' => Str::ucFirst(trim($request->content)),
                'guideline_id' => Crypt::decryptString($guidelineId)
            ]);
            $this->logActivity->generateLog('Registering Guide');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function updateGuide(Request $request, $guideId)
    {
        $validatedGuide = Validator::make($request->all(), [
            'label' => 'required',
            'content' => 'required'
        ]);

        if ($validatedGuide->passes()) {
            try {
                $this->guide->find($guideId)->update([
                    'label' => Str::lower(trim($request->label)),
                    'content' => Str::ucfirst(trim($request->content))
                ]);
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
            $this->guide->find($guideId)->delete();
            $this->logActivity->generateLog('Removing Guide');

            Alert::success(config('app.name'), 'Guide Removed Successfully.');
        } catch (\Exception $e) {
            Alert::error(config('app.name'), 'Failed to Remove Guide.');
        }

        return back();
    }
}
