<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;
    protected $table = 'quiz';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'guideline_id'
    ];
}
