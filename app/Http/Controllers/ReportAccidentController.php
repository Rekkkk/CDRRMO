<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ReportLog;
use App\Models\Reporting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\ReportIncident;
use App\Models\ActivityUserLog;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;


class ReportAccidentController extends Controller
{

    private $report, $reportLog, $logActivity, $reportAccident;

    function __construct()
    {
        $this->reportLog = new ReportLog;
        $this->report = new ReportIncident;
        $this->reportAccident = new Reporting;
        $this->logActivity = new ActivityUserLog;
    }

    public function displayPendingReport()
    {
        $pendingReport = $this->reportAccident->where('status', 'On Process')->get();

        return DataTables::of($pendingReport)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '';

                if ($row->user_ip == request()->ip() && !auth()->check())
                    $actionBtn .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Revert" class="btn-table-cancel py-1.5 btn-sm mr-2 revertIncidentReport">Revert</a>';
                else if (auth()->check())
                    return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Approve" id="approveIncidentReport" class="btn-submit py-1.5 btn-sm mr-2 approveIncidentReport">Approve</a>' . '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Decline" class="btn-table-cancel py-1.5 btn-sm mr-2 declineIncidentReport">Decline</a>';

                return $actionBtn;
            })->addColumn('photo', function ($row) {
                return '<img id="actualPhoto" src="' . asset('reports_image/' . $row->photo) . '"></img>';
            })
            ->rawColumns(['action', 'photo'])
            ->make(true);
    }

    public function displayIncidentReport()
    {
        $incidentReport = $this->reportAccident->whereNotIn('status', ["On Process"])->where('is_archive', 0)->get();

        return DataTables::of($incidentReport)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Archive" class="btn-table-cancel py-1.5 btn-sm mr-2 archiveIncidentReport">Archive</a>';
            })->addColumn('photo', function ($row) {
                return '<img id="actualPhoto" src="' . asset('reports_image/' . $row->photo) . '"></img>';
            })
            ->rawColumns(['action', 'photo'])
            ->make(true);
    }

    public function addAccidentReport(Request $request)
    {
        $validatedAccidentReport = Validator::make($request->all(), [
            'photo' => 'image|mimes:jpeg|max:2048'
        ]);

        if ($validatedAccidentReport->passes()) {
            $userIp = $this->reportLog->where('user_ip', $request->ip())->exists();
            $reportPhotoPath = $request->file('photo')->store();
            $request->photo->move(public_path('reports_image'), $reportPhotoPath);
            $reportAccident = [
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
                        return response()->json(['status' => 2, 'block_time' => "You have been blocked until $reportTime."]);
                    }
                }

                try {
                    $this->reportAccident->create($reportAccident);
                    $this->reportLog->where('user_ip', $request->ip())->update(['attempt' => $residentAttempt + 1]);
                    $attempt = $this->reportLog->where('user_ip', $request->ip())->value('attempt');

                    $attempt == 3 ? $this->reportLog->where('user_ip', $request->ip())->update(['report_time' => Carbon::now()->addDays(3)]) :
                        intval($this->reportLog->where('user_ip', $request->ip())->value('attempt'));

                    //event(new ReportIncident());

                    return response()->json(['status' => 0]);
                } catch (\Exception $e) {
                    return response()->json(['status' => 1]);
                }
            } else {
                try {
                    $this->reportAccident->create($reportAccident);
                    $this->reportLog->create([
                        'user_ip' => $request->ip(),
                        'attempt' => 1
                    ]);

                    //event(new ReportIncident());

                    return response()->json(['status' => 0]);
                } catch (\Exception $e) {
                    return response()->json(['status' => 1]);
                }
            }
        }

        return response()->json(['status' => 1, 'error' => $validatedAccidentReport->errors()->toArray()]);
    }

    public function approveAccidentReport($reportId)
    {
        try {
            $this->report->approveStatus($reportId);
            //event(new ReportIncident());
            $this->logActivity->generateLog('Approving Accident Report');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function declineAccidentReport($reportId)
    {
        try {
            $this->report->declineStatus($reportId);
            //event(new ReportIncident());
            $this->logActivity->generateLog('Declining Accident Report');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function revertAccidentReport($reportId)
    {
        try {
            $reportPhotoPath = $this->reportAccident->find($reportId)->value('photo');
            $this->report->revertReport($reportId, $reportPhotoPath);
            //event(new ReportIncident());

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
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

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }

    public function archiveReportAccident($reportId)
    {
        try {
            $this->reportAccident->find($reportId)->update([
                'is_archive' => 1
            ]);
            $this->logActivity->generateLog('Archiving Accident Report');

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }
}
