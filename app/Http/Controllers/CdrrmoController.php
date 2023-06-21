<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Evacuee;
use App\Models\Guideline;
use App\Models\EvacuationCenter;
use Illuminate\Support\Facades\Crypt;

class CdrrmoController extends Controller
{
    private $evacuee, $evacuation, $guideline, $guide;

    public function __construct()
    {
        $this->guide = new Guide;
        $this->evacuee = new Evacuee;
        $this->guideline = new Guideline;
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

    public function eligtasGuideline()
    {
        $guideline = $this->guideline->where('author', 1)->get();

        return view('userpage.guideline.eligtasGuideline', compact('guideline'));
    }

    public function guide($guidelineId)
    {
        $guide = $this->guide->where('guideline_id', Crypt::decryptString($guidelineId))->get();

        return view('userpage.guideline.guide', compact('guide', 'guidelineId'));
    }

    public function reportAccident()
    {
        return view('userpage.reportAccident');
    }

    public function hotlineNumbers()
    {
        return view('userpage.hotlineNumbers');
    }

    public function about()
    {
        return view('userpage.about');
    }
}
