<?php

namespace App\Http\Controllers;

use App\Models\Disaster;
use Illuminate\Http\Request;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class DisasterController extends Controller
{
    private $disaster, $logActivity;

    public function __construct()
    {
        $this->disaster = new Disaster;
        $this->logActivity = new ActivityUserLog;
    }
    public function displayDisasterInformation(Request $request)
    {
        if ($request->ajax()) {
            $disasterInformation = $this->disaster->where('is_archive', 0)->get();

            return DataTables::of($disasterInformation)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group items-center" role="group">' .
                        '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="btn-table-edit py-1.5 btn-sm mr-2 editDisaster">Edit</a>' .
                        '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Remove" class="btn-table-remove py-1.5 btn-sm mr-2 removeDisaster">Remove</a>' .
                        '<select class="custom-select bg-blue-500 text-white changeDisasterStatus" style="height:35px;">' .
                        '<option value="" disabled selected hidden>Change Status</option>' .
                        '<option value="On Going">On Going</option>' .
                        '<option value="Inactive">Inactive</option>' .
                        '</select></div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('userpage.disaster.disaster');
    }

    public function createDisasterData(Request $request)
    {
        $validatedDisasterData = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validatedDisasterData->passes()) {
            try {

                $this->disaster->create([
                    'name' => $request->name,
                    'location' => $request->location,
                    'status' => "On Going",
                    'is_archive' => 0
                ]);
                $this->logActivity->generateLog('Creating Disaster Data');

                return response()->json(['status' => 'success', 'message' => 'Disaster successfully created.']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
            }
        }

        return response()->json(['status' => 'warning', 'message' => 'Please fill out form correctly.']);
    }

    public function updateDisasterData(Request $request, $disasterId)
    {
        $validatedDisasterData = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validatedDisasterData->passes()) {
            try {
                $this->disaster->find($disasterId)->update([
                    'name' => $request->name,
                    'location' => $request->location
                ]);
                $this->logActivity->generateLog('Updating Disaster Data');

                return response()->json(['status' => 'success', 'message' => 'Disaster successfully updated.']);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
            }
        }

        return response()->json(['status' => 'warning', 'message' => 'Please fill out form correctly.']);
    }

    public function removeDisasterData($disasterId)
    {
        try {
            $this->disaster->find($disasterId)->update([
                'is_archive' => 1
            ]);
            $this->logActivity->generateLog('Removing Disaster Data');

            return response()->json(['status' => 'success', 'message' => 'Disaster successfully removed.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function changeDisasterStatus(Request $request, $disasterId)
    {
        try {
            $this->disaster->find($disasterId)->update([
                'status' => $request->status
            ]);
            $this->logActivity->generateLog('Change Disaster Status');

            return response()->json(['status' => 'success', 'message' => 'Disaster successfully changed status.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
        }
    }
}
