<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Barangay extends Model
{
    use HasFactory;

    protected $table = 'barangay';

    protected $primaryKey = 'barangay_id';

    protected $guarded = [];

    protected $fillable = [
        'barangay_name',
        'barangay_location',
        'barangay_contact_number',
        'barangay_email_address',
    ];

    public $timestamps = false;

    public function registerBarangayObject($barangay){
        return $this->create($barangay);
    }

    public function updateBarangayObject($request, $barangayId){
        $barangayData = [
            'barangay_name' => Str::ucfirst(trim($request->input('barangay_name'))),
            'barangay_location' => Str::ucfirst(trim($request->input('barangay_location'))),
            'barangay_contact_number' => trim($request->input('barangay_contact')),
            'barangay_email_address' => trim($request->input('barangay_email')),
        ];

        $barangay = $this->find($barangayId);
        $barangay->update($barangayData);
    }

    public function removeBarangayObject($barangay){
        $barangay = $this->find($barangay);
        $barangay->delete();
    }
}
