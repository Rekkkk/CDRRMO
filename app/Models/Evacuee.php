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

    public function countEvacueeOnEvacuation()
    {
      return $this->whereNull('date_out')->count();
    }

    public function countEvacueeReturned(){
        return $this->whereNotNull('date_out')->count();
    }

    public function countEvacuee($disasterId, $sex)
    {
        return $this->where('disaster_id', $disasterId)->where('sex', $sex)->count();
    }

    public function countEvacueeWithDisablities($disasterId){
        return $this->selectRaw('SUM(`4Ps`) AS `4Ps`, SUM(`PWD`) AS `PWD`, SUM(`pregnant`) AS `pregnant`, SUM(`lactating`) AS `lactating`, SUM(`student`) AS `student`, SUM(`working`) AS `working`')->where('disaster_id', $disasterId)->get();
    }

    public function recordEvacueeObject($evacuee)
    {
        return $this->insert($evacuee);
    }
}
