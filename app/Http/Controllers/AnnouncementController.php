<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    public function displayAnnouncement(){
        $cdrrmoAnnouncement = DB::table('admin_announcement')->orderBy('created_at', 'desc')->get();

        return $cdrrmoAnnouncement;
    }

    public function createAnnouncement(Request $request){
        
        $validatedAnnouncement = Validator::make($request->all(), [
            'announcement_description' => 'required',
            'announcement_content' => 'required',
            'announcement_video' => 'required',
            'announcement_image' => 'required',
        ]);

        if($validatedAnnouncement->passes()) {

            Announcement::create([
                'announcement_description' => $request->announcement_description,
                'announcement_content' => $request->announcement_content,
                'announcement_video' => $request->announcement_video,
                'announcement_image' => $request->announcement_image,
            ]);
    
            Alert::success('Announcement Already Posted', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/dashboard');
        }
        
        Alert::error('Failed to Post Announcement', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/dashboard');
    }

    public function editAnnouncement($announcement_id){
        return $announcement_id;
    }

    public function deleteAnnouncement($announcement_id){
        return $announcement_id;
    }
}
