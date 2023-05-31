<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvacuationCenter extends Model
{
    use HasFactory;

    protected $table = 'evacuation_center';

    protected $primaryKey = 'evacuation_center_id';

    protected $guarded = [];

    protected $fillable = [
        'evacuation_center_name',
        'evacuation_center_contact',
        'evacuation_center_address',
        'barangay_id',
        'latitude',
        'longitude'
    ];

    public $timestamps = false;

    public function registerEvacuationCenterObject($evacuationCenter){
        return $this->create($evacuationCenter);
    }

    public function updateEvacuationCenterObject($evacuationCenterData, $evacuationCenterId){
        $evacuationCenter = $this->find($evacuationCenterId);
        $evacuationCenter->update($evacuationCenterData);
    }

    public function removeEvacuationCenterObject($evacuationCenterId){
        $evacuationCenter = $this->find($evacuationCenterId);
        $evacuationCenter->delete();
    }
}