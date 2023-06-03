<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityUserLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'activity',
        'date_time'
    ];

    public $timestamps = false;

    public function generateLog($activity)
    {
        $activityLog = [
            'user_id' => Auth::user()->id,
            'activity' => $activity,
            'date_time' => Carbon::now()->toDayDateTimeString()
        ];

        $this->create($activityLog);
    }
}
