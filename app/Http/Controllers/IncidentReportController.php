<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ReportLog;
use App\Models\Reporting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\IncidentReport;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class IncidentReportController extends Controller
{

    private $report, $reportLog, $logActivity, $incidentReport;

    function __construct()
    {
        $this->reportLog = new ReportLog;
        $this->report = new IncidentReport;
        $this->incidentReport = new Reporting;
        $this->logActivity = new ActivityUserLog;
    }

    public function displayPendingIncidentReport()
    {
        $pendingReport = $this->incidentReport->where('status', 'On Process')->get();

        return DataTables::of($pendingReport)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '';

                if ($row->user_ip == request()->ip() && !auth()->check())
                    $actionBtn .= '<button class="btn-table-remove revertIncidentReport">Revert</button>';
                else if (auth()->check())
                    return '<button class="btn-table-submit p-1.5 px-3.5 mr-2 text-sm approveIncidentReport">Approve</button>' . '<button class="btn-table-remove declineIncidentReport">Decline</button>';

                return $actionBtn;
            })->addColumn('photo', function ($row) {
                return '<img id="actualPhoto" src="' . asset('reports_image/' . $row->photo) . '"></img>';
            })
            ->rawColumns(['action', 'photo'])
            ->make(true);
    }

    public function displayIncidentReport()
    {
        $incidentReport = $this->incidentReport->whereNotIn('status', ["On Process"])->where('is_archive', 0)->get();

        return DataTables::of($incidentReport)
            ->addIndexColumn()
            ->addColumn('action', function () {
                return '<button class="btn-table-remove removeIncidentReport">Remove</button>';
            })->addColumn('photo', function ($row) {
                return '<img id="actualPhoto" src="' . asset('reports_image/' . $row->photo) . '"></img>';
            })
            ->rawColumns(['action', 'photo'])
            ->make(true);
    }

    public function createIncidentReport(Request $request)
    {
        $validatedAccidentReport = Validator::make($request->all(), [
            'description' => 'required',
            'location' => 'required',
            'photo' => 'image|mimes:jpeg|max:2048'
        ]);

        if ($validatedAccidentReport->passes()) {
            $userIp = $this->reportLog->where('user_ip', $request->ip())->exists();
            $reportPhotoPath = $request->file('photo')->store();
            $request->photo->move(public_path('reports_image'), $reportPhotoPath);
            $incidentReport = [
                'description' => Str::ucFirst(trim($request->description)),
                'location' => Str::of(trim($request->location))->title(),
                'photo' => $reportPhotoPath,
                'status' => 'On Process',
                'user_ip' => $request->ip(),
                'is_archive' => 0
            ];

            if ($userIp) {
                $residentAttempt = $this->reportLog->where('user_ip', $request->ip())->value('attempt');
                $reportTime = $this->reportLog->where('user_ip', $request->ip())->value('report_time');

                if ($residentAttempt == 3) {
                    if ($reportTime <= Carbon::now()->toDateTimeString()) {
                        $this->reportLog->where('user_ip', $request->ip())->update(['attempt' => 0, 'report_time' => null]);
                        $residentAttempt = 0;
                    } else {
                        $reportTime = Carbon::parse($reportTime)->format('F j, Y H:i:s');
                        return response(['status' => 'blocked', 'message' => "You have been blocked until $reportTime."]);
                    }
                }

                try {
                    $this->incidentReport->create($incidentReport);
                    $this->reportLog->where('user_ip', $request->ip())->update(['attempt' => $residentAttempt + 1]);
                    $attempt = $this->reportLog->where('user_ip', $request->ip())->value('attempt');

                    $attempt == 3 ? $this->reportLog->where('user_ip', $request->ip())->update(['report_time' => Carbon::now()->addDays(3)]) :
                        intval($this->reportLog->where('user_ip', $request->ip())->value('attempt'));

                    //event(new IncidentReport());

                    return response(['status' => 'success', 'message' => 'Successfully reported, Thank for your concern.']);
                } catch (\Exception $e) {
                    return response()->json(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
                }
            }

            try {
                $this->incidentReport->create($incidentReport);
                $this->reportLog->create([
                    'user_ip' => $request->ip(),
                    'attempt' => 1
                ]);

                //event(new IncidentReport());

                return response(['status' => 'success', 'message' => 'Successfully reported, Thank for your concern.']);
            } catch (\Exception $e) {
                return response(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
            }
        }

        return response()->json(['status' => 'warning', 'message' => $validatedAccidentReport->errors()->first()]);
    }

    public function approveIncidentReport($reportId)
    {
        try {
            $this->report->approveStatus($reportId);
            //event(new IncidentReport());
            $this->logActivity->generateLog('Approving Incident Report');

            return response(['status' => 'success', 'message' => 'Incident report successfully approved.']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function declineIncidentReport($reportId)
    {
        try {
            $this->report->declineStatus($reportId);
            //event(new IncidentReport());
            $this->logActivity->generateLog('Declining Incident Report');

            return response(['status' => 'success', 'message' => 'Incident report successfully declined.']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function revertIncidentReport($reportId)
    {
        try {
            $reportPhotoPath = $this->incidentReport->find($reportId)->value('photo');
            $this->report->revertReport($reportId, $reportPhotoPath);
            //event(new IncidentReport());

            return response(['status' => 'success']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function updateUserAttempt()
    {
        try {
            $userReport = $this->reportLog->where('user_ip', request()->ip())->value('attempt');

            if ($userReport == 3) {
                $this->reportLog->where('user_ip', request()->ip())->update([
                    'attempt' => $userReport - 1,
                    'report_time' => null
                ]);
            } else {
                $this->reportLog->where('user_ip', request()->ip())->update([
                    'attempt' => $userReport - 1
                ]);
            }

            return response(['status' => 'success', 'message' => 'Incident report successfully reverted.']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function archiveIncidentReport($reportId)
    {
        try {
            $this->incidentReport->find($reportId)->update([
                'is_archive' => 1
            ]);
            $this->logActivity->generateLog('Removing Incident Report');

            return response(['status' => 'success', 'message' => 'Incident report successfully removed.']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'An error occurred while processing your request.']);
        }
    }
}
