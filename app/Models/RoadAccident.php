<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class road_accident extends Model
{
    use HasFactory;

    protected $table = 'road_accident';

    protected $primaryKey = 'road_accident_id';

    public $timestamps = false;

    protected $fillable = [
        'casualties',
        'injuries',
        'disaster_id'
    ];
}
