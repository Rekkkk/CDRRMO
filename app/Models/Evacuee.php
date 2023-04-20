<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evacuee extends Model
{
    use HasFactory;

    protected $table = 'evacuee';

    protected $primaryKey = 'evacuee_id';

    protected $guarded = [];

    protected $fillable = [
        'evacuee_id',
        'evacuee_first_name',
        'evacuee_middle_name',
        'evacuee_last_name',
        'evacuee_contact_number',
        'evacuee_age',
        'evacuee_gender',
        'evacuee_address',
        'barangay_id',
        'disaster_id',
        'evacuation_assigned',
    ];

    public $timestamps = false;

    public function recordEvacueeObject($evacuee){
        return $this->create($evacuee);
    }
}