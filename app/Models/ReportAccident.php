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
    ];

    public $timestamps = true;
}
