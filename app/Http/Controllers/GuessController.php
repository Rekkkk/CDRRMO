<?php

namespace App\Http\Controllers;

class GuessController extends Controller
{

    public function landingPage(){
        return view('/auth/authUser');
    }
    
    public function dashboard(){
        return view('/CDRRMO/dashboard');
    }

    public function guessEligtasGuidelines(){
        return view('/CDRRMO/eligtasGuidelines');
    }

    public function guessHotlineNumbers(){
        return view('/CDRRMO/hotlineNumbers');
    }

    public function guessStatistics(){
        return view('/CDRRMO/statistics');
    }

    public function guessAbout(){
        return view('/CDRRMO/about');
    }
}
