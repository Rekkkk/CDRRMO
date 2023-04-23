<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
