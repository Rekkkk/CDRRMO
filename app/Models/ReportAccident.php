<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportAccident extends Model
{
    use HasFactory;

    protected $table = 'report';

    protected $primaryKey = 'report_id';

    protected $guarded = [];

    protected $fillable = [
        'report_description',
        'report_location',
        'report_photo',
        'contact',
        'email',
        'status'
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
