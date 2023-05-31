<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Typhoon extends Model
{
    use HasFactory;

    protected $table = 'typhoon';

    protected $primaryKey = 'typhoon_id';

    public $timestamps = false;

    protected $fillable = [
        'typhoon_name',
        'typhoon_category',
        'disaster_id'
    ];
}
