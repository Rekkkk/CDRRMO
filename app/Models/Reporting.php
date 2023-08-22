<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporting extends Model
{
    use HasFactory;

    protected $table = 'report';

    protected $primaryKey = 'id';

    protected $fillable = [
        'description',
        'location',
        'photo',
        'latitude',
        'longitude',
        'status',
        'user_ip',
        'is_archive'
    ];

    public $timestamps = false;
}
