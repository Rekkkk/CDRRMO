<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityUserLog extends Model
{
    use HasFactory;

    protected $table = 'user_activity_log';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'email',
        'user_role',
        'role_name',
        'activity',
        'date_time'
    ];

    public $timestamps = true;
}
