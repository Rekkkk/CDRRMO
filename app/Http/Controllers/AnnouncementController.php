<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    public function displayAnnouncement(){
        $cdrrmoAnnouncement = DB::table('admin_announcement')->orderBy('created_at', 'desc')->get();

        return $cdrrmoAnnouncement;
    }

    public function createAnnouncement(){
        return 'Create';
    }

    public function editAnnouncement(){
        return view('CDRRMO.eligtasGuidelines');;
    }

    public function deleteAnnouncement(){
        
    }
}
