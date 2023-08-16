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
use Illuminate\Support\Facades\Crypt;
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
        $pendingReport = $this->incidentReport->where('status', 'On Process')->whereNotNull('photo')->get();

        return DataTables::of($pendingReport)
            ->addIndexColumn()
            ->addColumn('id', fn ($report) => Crypt::encryptString($report->id))
            ->addColumn('status', '<div class="status-container"><div class="status-content bg-warning">On Process</div></div>')
            ->addColumn('action', function ($report) {
                if (!auth()->check()) {
                    return $report->user_ip == request()->ip() ? '<button class="btn-table-remove" id="revertIncidentReport"><i class="bi bi-arrow-counterclockwise"></i>Revert</button>' : '';
                } elseif (auth()->user()->is_disable == 0) {
                    return '<div class="action-container">' .
                        '<button class="btn-table-submit" id="approveIncidentReport"><i class="bi bi-check-circle-fill"></i>Approve</button>' .
                        '<button class="btn-table-remove" id="declineIncidentReport"><i class="bi bi-x-circle-fill"></i>Decline</button>' .
                        '</div>';
                } else {
                    return '<span class="message-text">Currently Disabled.</span>';
                }
            })
            ->addColumn('photo', fn ($report) => '<div class="photo-container">
                    <div class="image-wrapper">
                        <img class="report-img" src="' . asset('reports_image/' . $report->photo) . '">
                        <div class="image-overlay">
                            <div class="overlay-text">View Photo</div>
                        </div>
                    </div>
                </div>')
            ->rawColumns(['id', 'status', 'action', 'photo'])
            ->make(true);
    }

    public function displayIncidentReport()
    {
        $incidentReport = $this->incidentReport->whereNotIn('status', ['On Process'])->where('is_archive', 0)->get();

        return DataTables::of($incidentReport)
            ->addIndexColumn()
            ->addColumn('id', fn ($report) => Crypt::encryptString($report->id))
            ->addColumn('status', fn ($report) => '<div class="status-container"><div class="status-content bg-' . match ($report->status) {
                'Approved' => 'success',
                'Declined' => 'danger'
            }
                . '">' . $report->status . '</div></div>')
            ->addColumn('action', fn () => auth()->user()->is_disable == 0 ? '<button class="btn-table-remove" id="removeIncidentReport"><i class="bi bi-trash3-fill"></i>Remove</button>' :
                '<span class="message-text">Currently Disabled.</span>')
            ->addColumn('photo', fn ($report) => '<div class="photo-container">
                    <div class="image-wrapper">
                        <img class="report-img" src="' . asset('reports_image/' . $report->photo) . '">
                        <div class="image-overlay">
                            <div class="overlay-text">View Photo</div>
                        </div>
                    </div>
                </div>')
            ->rawColumns(['id', 'status', 'action', 'photo'])
            ->make(true);
    }

    public function createIncidentReport(Request $request)
    {
        $incidentReportValidation = Validator::make($request->all(), [
            'description' => 'required',
            'location' => 'required',
            'photo' => 'image|mimes:jpeg|max:2048'
        ]);

        if ($incidentReportValidation->fails())
            return response(['status' => 'warning', 'message' => $incidentReportValidation->errors()->first()]);

        $resident = $this->reportLog->where('user_ip', $request->ip())->first();
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

        if ($resident) {
            $residentAttempt = $resident->attempt;
            $reportTime = $resident->report_time;

            if ($residentAttempt == 3) {
                $isBlock = $this->isBlocked($reportTime);

                if (!$isBlock) {
                    $resident->update(['attempt' => 0, 'report_time' => null]);
                    $residentAttempt = 0;
                } else {
                    return response(['status' => 'blocked', 'message' => "You have been blocked until  $isBlock."]);
                }
            }

            $this->incidentReport->create($incidentReport);
            $resident->update(['attempt' => $residentAttempt + 1]);
            $attempt = $resident->attempt;
            $attempt == 3 ? $resident->update(['report_time' => Carbon::now()->addHours(3)]) : null;
            //event(new IncidentReport());
            return response()->json();
        }

        $this->incidentReport->create($incidentReport);
        $this->reportLog->create([
            'user_ip' => $request->ip(),
            'attempt' => 1
        ]);
        //event(new IncidentReport());
        return response()->json();
    }

    public function approveIncidentReport($reportId)
    {
        $this->report->approveStatus(Crypt::decryptString($reportId));
        $this->logActivity->generateLog('Approving Incident Report');
        //event(new IncidentReport());
        return response()->json();
    }

    public function declineIncidentReport($reportId)
    {
        $this->report->declineStatus(Crypt::decryptString($reportId));
        $this->logActivity->generateLog('Declining Incident Report');
        //event(new IncidentReport());
        return response()->json();
    }

    public function revertIncidentReport($reportId)
    {
        $reportId = Crypt::decryptString($reportId);
        $reportPhotoPath = $this->incidentReport->find($reportId)->value('photo');
        $this->report->revertIncidentReport($reportId, $reportPhotoPath);
        //event(new IncidentReport());
        return response()->json();
    }

    public function removeIncidentReport($reportId)
    {
        $this->incidentReport->find(Crypt::decryptString($reportId))->update([
            'is_archive' => 1
        ]);
        $this->logActivity->generateLog('Removing Incident Report');
        //event(new IncidentReport());
        return response()->json();
    }

    public function displayDangerousAreasReport(Request $request)
    {
        if (!$request->ajax()) return view('userpage.dangerousAreasReport');

        $dangerousAreasReport = $this->incidentReport->whereIn('status', ['On Process', 'Confirmed'])->where('is_archive', 0)->whereNull('photo')->get();

        return DataTables::of($dangerousAreasReport)
            ->addIndexColumn()
            ->addColumn('id', fn ($dangerousAreas) => Crypt::encryptString($dangerousAreas->id))
            ->addColumn('status', fn ($dangerousAreas) => '<div class="status-container"><div class="status-content bg-' . match ($dangerousAreas->status) {
                'Confirmed' => 'success',
                'On Process' => 'warning'
            }
                . '">' . $dangerousAreas->status . '</div></div>')
            ->addColumn('action', function ($dangerousAreas) {
                if (!auth()->check()) {
                    return $dangerousAreas->user_ip == request()->ip() ? '<button class="btn-table-remove" id="revertDangerousAreaReport"><i class="bi bi-arrow-counterclockwise"></i>Revert</button>' : '';
                } elseif (auth()->user()->is_disable == 0) {
                    return '<div class="action-container">' .
                        ($dangerousAreas->status == "Confirmed"
                            ? '<button class="btn-table-remove removeDangerAreaReport"><i class="bi bi-trash3-fill"></i>Remove</button>'
                            : '<button class="btn-table-submit confirmDangerAreaReport"><i class="bi bi-check-circle-fill"></i>Confirm</button>' .
                            '<button class="btn-table-remove rejectDangerAreaReport"><i class="bi bi-x-circle-fill"></i>Reject</button>') .
                        '</div>';
                } else {
                    return '<span class="message-text">Currently Disabled.</span>';
                }
            })
            ->rawColumns(['id', 'status', 'action'])
            ->make(true);
    }

    public function reportDangerousArea(Request $request)
    {
        $dangerousAreasReportValidation = Validator::make($request->all(), [
            'report_type' => 'required',
            'location' => 'required'
        ]);

        if ($dangerousAreasReportValidation->fails())
            return response(['status' => 'warning', 'message' => $dangerousAreasReportValidation->errors()->first()]);

        $resident = $this->reportLog->where('user_ip', $request->ip())->first();
        $dangerAreaReport = [
            'description' => Str::ucFirst(trim($request->report_type)),
            'location' => Str::of(trim($request->location))->title(),
            'photo' => null,
            'status' => 'On Process',
            'user_ip' => $request->ip(),
            'is_archive' => 0
        ];

        if ($resident) {
            $residentAttempt = $resident->attempt;
            $reportTime = $resident->report_time;

            if ($residentAttempt == 3) {
                $isBlock = $this->isBlocked($reportTime);

                if (!$isBlock) {
                    $resident->update(['attempt' => 0, 'report_time' => null]);
                    $residentAttempt = 0;
                } else {
                    return response(['status' => 'blocked', 'message' => "You have been blocked until  $isBlock."]);
                }
            }

            $this->incidentReport->create($dangerAreaReport);
            $resident->update(['attempt' => $residentAttempt + 1]);
            $attempt = $resident->attempt;
            $attempt == 3 ? $resident->update(['report_time' => Carbon::now()->addHours(3)]) : null;
            //event(new IncidentReport());
            return response()->json();
        }

        $this->incidentReport->create($dangerAreaReport);
        $this->reportLog->create([
            'user_ip' => $request->ip(),
            'attempt' => 1
        ]);
        //event(new IncidentReport());
        return response()->json();
    }

    public function revertDangerousAreaReport($dangerAreaId)
    {
        $dangerAreaId = Crypt::decryptString($dangerAreaId);
        $this->report->revertDangerAreaReport($dangerAreaId);
        //event(new IncidentReport());
        return response()->json();
    }

    public function confirmDangerAreaReport($dangerAreaId)
    {
        $this->report->confirmDangerAreaReport(Crypt::decryptString($dangerAreaId));
        $this->logActivity->generateLog('Confirming Dangerous Area Report');
        //event(new IncidentReport());
        return response()->json();
    }

    public function rejectDangerAreaReport($dangerAreaId)
    {
        $this->incidentReport->find(Crypt::decryptString($dangerAreaId))->delete();
        $this->logActivity->generateLog('Rejecting Dangerous Area Report');
        //event(new IncidentReport());
        return response()->json();
    }

    public function removeDangerAreaReport($dangerAreaId)
    {
        $this->report->removeDangerAreaReport(Crypt::decryptString($dangerAreaId));
        $this->logActivity->generateLog('Removing Dangerous Area Report');
        //event(new IncidentReport());
        return response()->json();
    }

    public function updateUserAttempt()
    {
        $userIp = request()->ip();
        $resident = $this->reportLog->where('user_ip', $userIp)->first();

        if ($resident) {
            $resident->decrement('attempt');
            $resident->attempt == 2 ? $resident->update(['report_time' => null]) : ($resident->attempt == 0 ?  $resident->delete() : null);
        }

        return response()->json();
    }

    private function isBlocked($reportTime)
    {
        return $reportTime <= Carbon::now()->toDateTimeString() ? false : Carbon::parse($reportTime)->format('F j, Y H:i:s');
    }
}
