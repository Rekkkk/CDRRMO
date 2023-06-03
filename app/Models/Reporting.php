<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporting extends Model
{
    use HasFactory;

    protected $table = 'report';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'description',
        'location',
        'photo',
        'status'
    ];

    public $timestamps = false;

    public function registerAccidentReportObject($accidentReport){
        return $this->create($accidentReport);
    }

    public function approveAccidentReportObject($accidentReportId){
        $approvedReport = [
            'status' => 'Approved'
        ];

        $accidentReport = $this->find($accidentReportId);
        $accidentReport->update($approvedReport);
    }

    public function removeAccidentReportObject($accidentReportId){
        $accidentReport = $this->find($accidentReportId);
        $accidentReport->delete();
    }
}
