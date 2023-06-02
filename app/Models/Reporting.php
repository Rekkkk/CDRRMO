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

    public function registerAccidentReportObject($accidentReport){
        return $this->create($accidentReport);
    }

    public function removeAccidentReportObject($accidentReportId){
        $accidentReport = $this->find($accidentReportId);
        $accidentReport->delete();
    }
}
