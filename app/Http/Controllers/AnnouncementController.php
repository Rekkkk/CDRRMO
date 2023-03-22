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
        ]);

        if($validatedAnnouncement->passes()) {

            Announcement::create([
                'announcement_description' => $request->announcement_description,
                'announcement_content' => $request->announcement_content,
                'announcement_video' => $request->announcement_video,
                'announcement_image' => $request->announcement_image,
            ]);
    
            Alert::success('Announcement Posted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/dashboard');
        }
        
        Alert::error('Failed to Post Announcement', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/dashboard');
    }

    public function editAnnouncement($announcement_id){
        $announcement = Announcement::findOrFail($announcement_id);

        return view('partials.dashboard.updateAnnouncement', ['announcements' => $announcement]);
    }

    public function updateAnnouncement(Request $request, $announcement_id){
        $validatedAnnouncement = Validator::make($request->all(), [
            'announcement_description' => 'required',
            'announcement_content' => 'required',
        ]);

        if($validatedAnnouncement->passes()){

            $announcement_description = $request->input('announcement_description');
            $announcement_content = $request->input('announcement_content');
            $announcement_video = $request->input('announcement_video');
            $announcement_image = $request->input('announcement_image');

            $updatedAnnouncement = Announcement::where('announcement_id', $announcement_id)->update([
                'announcement_description' => $announcement_description,
                'announcement_content' => $announcement_content,
                'announcement_video' => $announcement_video,
                'announcement_image' => $announcement_image,
            ]);

            if($updatedAnnouncement){
                Alert::success('Announcement Updated Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/dashboard');
            }
            else{
                Alert::error('Failed to Update Announcement', 'Cabuyao City Disaster Risk Reduction Management Office');
                return redirect('cdrrmo/dashboard');
            }
        }

        Alert::error('Failed to Update Announcement', 'Cabuyao City Disaster Risk Reduction Management Office');
        return redirect('cdrrmo/dashboard');
    }

    public function deleteAnnouncement($announcement_id){

        $deletedAnnouncement = DB::table('admin_announcement')->where('announcement_id', $announcement_id)->delete();
        
        if($deletedAnnouncement){
            Alert::success('Announcement Deleted Successfully', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/dashboard');
        }
        else{
            Alert::error('Failed to Deleted Announcement', 'Cabuyao City Disaster Risk Reduction Management Office');
            return redirect('cdrrmo/dashboard');
        }
    }
}