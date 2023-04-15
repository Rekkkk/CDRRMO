<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $table = 'guide';

    protected $primaryKey = 'guide_id';

    protected $guarded = [];

    protected $fillable = [
        'guide_id',
        'guide_description',
        'guide_content',
        'guidelines_id',
    ];

    public $timestamps = true;
}
