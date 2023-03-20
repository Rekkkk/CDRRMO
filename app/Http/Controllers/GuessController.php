<?php

namespace App\Http\Controllers;

class GuessController extends Controller
{
    public function dashboard(){
        $cdrrmoAnnouncement = new AnnouncementController();
        $cdrrmoAnnouncement = $cdrrmoAnnouncement->displayAnnouncement();

        return view('/CDRRMO/dashboard' , ['announcements' => $cdrrmoAnnouncement]);
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
