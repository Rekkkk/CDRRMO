<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earthquake extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'earthquake_id',
        'magnitude',
        'month',
    ];
}
