<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evacuee extends Model
{
    use HasFactory;

    protected $table = 'evacuee';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'house_hold_number',
        'name',
        'sex',
        'age',
        '4Ps',
        'PWD',
        'pregnant',
        'lactating',
        'student',
        'working',
        'barangay',
        'date_entry',
        'date_out',
        'disaster_id',
        'evacuation_assigned'
    ];


    public function recordEvacueeObject($evacuee)
    {
        return $this->insert($evacuee);
    }
}
