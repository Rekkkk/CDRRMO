<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evacuee extends Model
{
    use HasFactory;

    protected $table = 'evacuee';

    protected $primaryKey = 'id';

    protected $fillable = [
        'house_hold_number',
        'sex',
        'age',
        'PWD',
        'pregnant',
        'lactating',
        'barangay',
        'date_entry',
        'disaster_name',
        'disaster_id',
        'evacuation_assigned',
        'remarks'
    ];

    public $timestamps = false;

    // public function countEvacuee($disaster, $sex)
    // {
    //     return $this->where('disaster_type', $disaster)->where('sex', $sex)->count();
    // }

    // public function countEvacueeWithDisabilities($disaster)
    // {
    //     return $this->selectRaw('SUM(`fourps`) AS `fourps`, SUM(`PWD`) AS `PWD`, SUM(`pregnant`) AS `pregnant`, SUM(`lactating`) AS `lactating`, SUM(`student`) AS `student`, SUM(`working`) AS `working`')->where('disaster_type', $disaster)->get();
    // }
}
