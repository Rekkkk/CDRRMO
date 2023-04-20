<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EvacuationCenter extends Model
{
    use HasFactory;

    protected $table = 'evacuation_center';

    protected $primaryKey = 'evacuation_center_id';

    protected $guarded = [];

    protected $fillable = [
        'evacuation_center_name',
        'evacuation_center_contact',
        'evacuation_center_location',
    ];

    public $timestamps = false;

    public function registerEvacuationCenterObject($evacuationCenter){
        return $this->create($evacuationCenter);
    }

    public function updateEvacuationCenterObject($request, $evacuationCenterId){
        $evacuationCenterData = [
            'evacuation_center_name' => Str::ucfirst(trim($request->input('evacuation_center_name'))),
            'evacuation_center_contact' => trim($request->input('evacuation_center_contact')),
            'evacuation_center_location' => Str::ucfirst(trim($request->input('evacuation_center_location'))),
        ];

        $evacuationCenter = $this->find($evacuationCenterId);
        $evacuationCenter->update($evacuationCenterData);
    }

    public function removeEvacuationCenterObject($evacuationCenterId){
        $evacuationCenter = $this->find($evacuationCenterId);
        $evacuationCenter->delete();
    }
}