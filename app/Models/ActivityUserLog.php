<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityUserLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'activity',
        'date_time'
    ];

    public $timestamps = false;

    public function generateLog($activity)
    {
        $this->create([
            'user_id' => auth()->user()->id,
            'activity' => trim($activity),
            'date_time' => Carbon::now()->toDayDateTimeString()
        ]);
    }
}
