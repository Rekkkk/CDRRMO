<?php

namespace App\Http\Controllers;

use App\Models\Disaster;
use Illuminate\Support\Str;
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
            $disasterInformation = $this->disaster->where('is_archive', 0)->orderBy('id', 'desc')->get();

            return DataTables::of($disasterInformation)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $color = match ($row->status) {
                        'On Going' => 'success',
                        'Inactive' => 'danger',
                    };

                    return '<div class="status-container"><div class="status-content bg-' . $color . '">' . $row->status . '</div></div>';
                })->addColumn('action', function ($row) {
                    if (auth()->user()->is_disable == 0) {
                        $statusOptions = $row->status == 'On Going' ? '<option value="Inactive">Inactive</option>' : '<option value="On Going">On Going</option>';

                        return '<div class="action-container">' .
                            '<button class="btn-table-update updateDisaster"><i class="bi bi-pencil-square"></i>Update</button>' .
                            '<button class="btn-table-remove removeDisaster"><i class="bi bi-trash3-fill"></i>Remove</button>' .
                            '<select class="form-select changeDisasterStatus">' .
                            '<option value="" disabled selected hidden>Change Status</option>' . $statusOptions . '</select></div>';
                    }

                    return '<span class="message-text">Currently Disabled.</span>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('userpage.disaster.disaster');
    }

    public function createDisasterData(Request $request)
    {
        $validatedDisasterData = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validatedDisasterData->fails())
            return response(['status' => 'warning', 'message' => $validatedDisasterData->errors()->first()]);

        $this->disaster->create([
            'name' => Str::ucsplit(trim($request->name)),
            'status' => "On Going",
            'is_archive' => 0
        ]);
        $this->logActivity->generateLog('Creating Disaster Data');
        return response()->json();
    }

    public function updateDisasterData(Request $request, $disasterId)
    {
        $validatedDisasterData = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validatedDisasterData->fails())
            return response()->json(['status' => 'warning', 'message' => $validatedDisasterData->errors()->first()]);

        $this->disaster->find($disasterId)->update([
            'name' => Str::ucsplit(trim($request->name))
        ]);
        $this->logActivity->generateLog('Updating Disaster Data');
        return response()->json();
    }

    public function removeDisasterData($disasterId)
    {
        $this->disaster->find($disasterId)->update([
            'status' => 'Archived',
            'is_archive' => 1

        ]);
        $this->logActivity->generateLog('Removing Disaster Data');
        return response()->json();
    }

    public function changeDisasterStatus(Request $request, $disasterId)
    {
        $this->disaster->find($disasterId)->update([
            'status' => $request->status
        ]);
        $this->logActivity->generateLog('Changing Disaster Status');
        return response()->json();
    }
}
