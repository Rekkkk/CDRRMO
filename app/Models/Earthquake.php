<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class earthquake extends Model
{
    use HasFactory;

    protected $table = 'earthquake';

    protected $primaryKey = 'earthquake_id';

    public $timestamps = false;

    protected $fillable = [
        'magnitude',
        'disaster_id'
    ];
}
