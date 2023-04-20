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
        'barangay_id',
        'barangay_name',
        'barangay_location',
        'barangay_contact_number',
        'barangay_email_address',
    ];

    public $timestamps = false;

    public function registerBarangayObject($barangay){
        return $this->create($barangay);
    }

    public function updateBarangayObject($request, $barangay_id){
        $barangayData = [
            'barangay_name' => Str::ucfirs(trim($request->input('baranggay_name'))),
            'barangay_location' => Str::ucfirst(trim($request->input('baranggay_location'))),
            'barangay_contact_number' => trim($request->input('baranggay_contact')),
            'barangay_email_address' => trim($request->input('baranggay_email')),
        ];

        $disaster = $this->find($barangay_id);
        $disaster->update($barangayData);
    }

    public function removeBarangayObject($barangay){
        $barangay = $this->find($barangay);
        $barangay->delete();
    }
}