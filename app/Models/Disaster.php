<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disaster extends Model
{
    use HasFactory;

    protected $table = 'disaster';

    protected $primaryKey = 'disaster_number';

    protected $guarded = [];

    protected $fillable = [
        'disaster_number',
        'disaster_label',
    ];

    public $timestamps = false;
}