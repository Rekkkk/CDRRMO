<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvacuationCenter extends Model
{
    use HasFactory;

    protected $table = 'evacuation_center';

    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'barangay_name',
        'latitude',
        'longitude',
        'status'
    ];

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