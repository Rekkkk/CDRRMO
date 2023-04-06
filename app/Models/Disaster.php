<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disaster extends Model
{
    use HasFactory;

    protected $table = 'disaster';

    protected $primaryKey = 'disaster_id';

    protected $guarded = [];

    protected $fillable = [
        'disaster_id',
        'disaster_name',
    ];

    public $timestamps = false;
}