<?php

namespace App\Events;

use App\Models\Reporting;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportIncident implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $reportAccident;

    public function __construct()
    {
        
    }

    function approveStatus($accidentReportId){
        $this->reportAccident = new Reporting;
        $this->reportAccident->approveAccidentReportObject($accidentReportId);
    }

    function declineStatus($accidentReportId){
        $this->reportAccident = new Reporting;
        $this->reportAccident->removeAccidentReportObject($accidentReportId);
    }

    public function broadcastOn()
    {
        return new Channel('report-incident');
    }
}
