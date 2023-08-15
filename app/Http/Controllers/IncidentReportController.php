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
        $pendingReport = $this->incidentReport->where('status', 'On Process')->get();

        return DataTables::of($pendingReport)
            ->addIndexColumn()
            ->addColumn('id', fn ($report) => Crypt::encryptString($report->id))
            ->addColumn('status', '<div class="status-container"><div class="status-content bg-warning">On Process</div></div>')
            ->addColumn('action', function ($report) {
                if (!auth()->check()) {
                    return $report->user_ip == request()->ip() ? '<button class="btn-table-remove" id="revertIncidentReport"><i class="bi bi-arrow-counterclockwise"></i>Revert</button>' : '';
                } elseif (auth()->user()->is_disable == 0) {
                    return '<div class="action-container">' .
                        '<button class="btn-table-submit approveIncidentReport"><i class="bi bi-check-circle-fill"></i>Approve</button>' .
                        '<button class="btn-table-remove declineIncidentReport"><i class="bi bi-x-circle-fill"></i>Decline</button>' .
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
            ->addColumn('action', fn () => auth()->user()->is_disable == 0 ? '<button class="btn-table-remove removeIncidentReport"><i class="bi bi-trash3-fill"></i>Remove</button>' :
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
                if ($reportTime <= Carbon::now()->toDateTimeString()) {
                    $resident->update(['attempt' => 0, 'report_time' => null]);
                    $residentAttempt = 0;
                } else {
                    $reportTime = Carbon::parse($reportTime)->format('F j, Y H:i:s');
                    return response(['status' => 'blocked', 'message' => "You have been blocked until $reportTime."]);
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
        $this->report->revertReport($reportId, $reportPhotoPath);
        //event(new IncidentReport());
        return response()->json();
    }

    public function updateUserAttempt()
    {
        $userIp = request()->ip();
        $resident = $this->reportLog->where('user_ip', $userIp)->get();
        $resident->decrement('attempt');

        return $resident->value('attempt') == 2 ? $resident->update(['report_time' => null]) : response()->json();
    }

    public function removeIncidentReport($reportId)
    {
        $this->incidentReport->find(Crypt::decryptString($reportId))->update([
            'is_archive' => 1
        ]);
        $this->logActivity->generateLog('Removing Incident Report');
        return response()->json();
    }
}
