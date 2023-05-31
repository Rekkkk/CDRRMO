<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityUserLog extends Model
{
    use HasFactory;

    protected $table = 'user_activity_log';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'email',
        'user_role',
        'role_name',
        'activity',
        'date_time'
    ];

    public $timestamps = false;

    public function generateLog($activity)
    {

        $activityLog = [
            'email' => Auth::user()->email,
            'user_role' => Auth::user()->user_role,
            'role_name' => Auth::user()->role_name,
            'activity' => $activity,
            'date_time' => Carbon::now()->toDayDateTimeString()
        ];

        $this->create($activityLog);
    }
}
