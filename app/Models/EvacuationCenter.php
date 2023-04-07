<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvacuationCenter extends Model
{
    use HasFactory;

    protected $table = 'evacuation_center';

    protected $primaryKey = 'evacuation_id';

    protected $guarded = [];

    protected $fillable = [
        'evacuation_name',
        'evacuation_contact',
        'evacuation_location',
    ];

    public $timestamps = false;
}
