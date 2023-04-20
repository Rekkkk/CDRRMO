<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAccident extends Model
{
    use HasFactory;

    protected $table = 'report';

    protected $primaryKey = 'report_id';

    protected $guarded = [];

    protected $fillable = [
        'report_id',
        'report_description',
        'report_location',
        'contact',
        'email',
        'status',
    ];

    public $timestamps = true;

    public function registerAccidentReportObject($accidentReport){
        return $this->create($accidentReport);
    }

    public function removeAccidentReportObject($accidentReportId){
        $accidentReport = $this->find($accidentReportId);
        $accidentReport->delete();
    }
}