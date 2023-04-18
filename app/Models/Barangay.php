<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}