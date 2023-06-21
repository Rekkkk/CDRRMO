<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashflood extends Model
{
    use HasFactory;

    protected $table = 'typhoon';

    protected $primaryKey = 'id';

    protected $fillable = [
        'location',
        'disaster_id',
        'status'
    ];

    public function retrieveAll()
    {
        return $this->all();
    }
}
