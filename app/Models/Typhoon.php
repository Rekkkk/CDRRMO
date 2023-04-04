<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typhoon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'typhoon_id',
        'age_range',
        'male',
        'female',
    ];
}
