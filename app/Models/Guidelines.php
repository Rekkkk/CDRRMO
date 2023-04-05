<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guidelines extends Model
{
    use HasFactory;

    protected $table = 'guidelines';

    protected $primaryKey = 'guidelines_id';

    protected $guarded = [];

    protected $fillable = [
        'guidelines_id',
        'guidelines_description',
        'guidelines_content',
    ];

    public $timestamps = true;
}
