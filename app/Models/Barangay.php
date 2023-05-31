<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'barangay_email_address'
    ];

    public $timestamps = false;

    public function registerBarangayObject($barangay)
    {
        return $this->create($barangay);
    }

    public function updateBarangayObject($barangayData, $barangayId)
    {
        $barangay = $this->find($barangayId);
        $barangay->update($barangayData);
    }

    public function removeBarangayObject($barangay)
    {
        $barangay = $this->find($barangay);
        $barangay->delete();
    }
}
