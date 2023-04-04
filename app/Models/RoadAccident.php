<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoadAccident extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'accident_id',
        'location',
        'casualties',
        'injured',
    ];
}
