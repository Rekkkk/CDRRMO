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
        'status',
        'user_ip'
    ];

    public $timestamps = false;
}
